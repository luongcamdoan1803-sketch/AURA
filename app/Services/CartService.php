<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Support\Collection;

/**
 * Xử lý giỏ hàng bằng Session.
 *
 * Session chỉ lưu product_id và số lượng. Tên, hình, giá luôn được đọc lại
 * từ CSDL gốc mỗi lần hiển thị, nên dữ liệu không bao giờ bị lệch.
 *
 * Có 2 "nguồn" sản phẩm:
 *  - 'cart'   : giỏ hàng bình thường (nút "Thêm vào giỏ")
 *  - 'buynow' : 1 sản phẩm duy nhất khi bấm "Mua ngay"
 */
class CartService
{
    /* ---------- Tiện ích ---------- */

    public static function money($amount): string
    {
        return number_format((float) $amount, 0, ',', '.') . 'đ';
    }

    public function maxQty(): int
    {
        return (int) config('aura.max_qty', 99);
    }

    public function normalizeMode(?string $mode): string
    {
        return $mode === 'buynow' ? 'buynow' : 'cart';
    }

    /* Giá bán thực tế của 1 sản phẩm (đã trừ % giảm giá của sản phẩm) */
    public function unitPrice(Product $product): int
    {
        $percent = (int) ($product->discount_percent ?? 0);

        return (int) round($product->price * (1 - $percent / 100));
    }

    /* ---------- Đọc / ghi Session ---------- */

    protected function read(string $mode): array
    {
        if ($mode === 'buynow') {
            $item = session('buy_now');

            return $item ? [(int) $item['product_id'] => (int) $item['qty']] : [];
        }

        return session('cart', []);
    }

    protected function write(string $mode, array $items): void
    {
        if ($mode === 'buynow') {
            if ($items) {
                session(['buy_now' => [
                    'product_id' => array_key_first($items),
                    'qty'        => reset($items),
                ]]);
            } else {
                session()->forget('buy_now');
            }

            return;
        }

        session(['cart' => $items]);
    }

    /* ---------- Thao tác giỏ hàng ---------- */

    public function add(int $productId, int $qty): void
    {
        $items = $this->read('cart');

        $items[$productId] = min(
            $this->maxQty(),
            ($items[$productId] ?? 0) + max(1, $qty)
        );

        $this->write('cart', $items);
    }

    /* "Mua ngay": thay thế sản phẩm đang mua ngay */
    public function buyNow(int $productId, int $qty): void
    {
        $this->write('buynow', [
            $productId => min($this->maxQty(), max(1, $qty)),
        ]);
    }

    public function setQty(int $productId, int $qty, string $mode): void
    {
        $items = $this->read($mode);

        if (!isset($items[$productId])) {
            return;
        }

        $items[$productId] = min($this->maxQty(), max(1, $qty));

        $this->write($mode, $items);
    }

    public function remove(int $productId, string $mode): void
    {
        $items = $this->read($mode);

        unset($items[$productId]);

        $this->write($mode, $items);
    }

    public function clear(string $mode): void
    {
        $this->write($mode, []);
    }

    /* Số dòng sản phẩm trong giỏ (hiện ở icon giỏ hàng trên header) */
    public function count(): int
    {
        return count($this->read('cart'));
    }

    /* ---------- Dữ liệu hiển thị ---------- */

    /**
     * Danh sách dòng sản phẩm lấy từ CSDL.
     * Sản phẩm đã bị xóa khỏi CSDL sẽ tự động bị loại khỏi giỏ.
     */
    public function lines(string $mode): Collection
    {
        $items = $this->read($mode);

        if (!$items) {
            return collect();
        }

        $products = Product::with('category')
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        $lines = collect();
        $valid = [];

        foreach ($items as $id => $qty) {
            $product = $products->get($id);

            if (!$product) {
                continue;
            }

            $valid[$id] = $qty;
            $unit = $this->unitPrice($product);

            $lines->push((object) [
                'product'    => $product,
                'qty'        => $qty,
                'unit_price' => $unit,
                'line_total' => $unit * $qty,
            ]);
        }

        if (count($valid) !== count($items)) {
            $this->write($mode, $valid);
        }

        return $lines;
    }

    /* ---------- Mã giảm giá ---------- */

    /* Voucher đang áp dụng (đọc lại từ bảng vouchers) */
    public function appliedVoucher(): ?Voucher
    {
        $code = session('voucher_code');

        if (!$code) {
            return null;
        }

        $voucher = Voucher::findByCode($code);

        if (!$voucher || !$voucher->isAvailable()) {
            session()->forget('voucher_code');

            return null;
        }

        return $voucher;
    }

    /* Áp mã. Trả về [thành công?, thông báo] */
    public function applyVoucher(string $code, Collection $lines): array
    {
        if ($lines->isEmpty()) {
            return [false, 'Giỏ hàng đang trống, không thể áp mã giảm giá.'];
        }

        $voucher = Voucher::findByCode($code);

        if (!$voucher) {
            return [false, 'Mã giảm giá không tồn tại.'];
        }

        if (!$voucher->isAvailable()) {
            return [false, 'Mã giảm giá này đã hết lượt sử dụng.'];
        }

        session(['voucher_code' => $voucher->code]);

        return [true, 'Áp dụng mã ' . $voucher->code . ' thành công: giảm ' . $voucher->discount_percent . '%.'];
    }

    public function forgetVoucher(): void
    {
        session()->forget('voucher_code');
    }

    /* ---------- Tổng tiền ---------- */

    public function summary(Collection $lines, ?Voucher $voucher): array
    {
        $subtotal = (int) $lines->sum('line_total');
        $discount = $voucher ? min($subtotal, $voucher->discountFor($subtotal)) : 0;
        $shipping = $lines->isEmpty() ? 0 : (int) config('aura.shipping_fee', 0);

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total'    => $subtotal - $discount + $shipping,
        ];
    }

    /* Dữ liệu JSON trả về cho các thao tác AJAX */
    public function payload(string $mode, ?int $productId = null, ?string $message = null): array
    {
        $lines   = $this->lines($mode);
        $voucher = $this->appliedVoucher();
        $summary = $this->summary($lines, $voucher);
        $line    = $productId ? $lines->firstWhere('product.id', $productId) : null;

        return [
            'success' => true,
            'message' => $message,
            'count'   => $this->count(),
            'empty'   => $lines->isEmpty(),
            'line'    => $line ? [
                'id'         => $line->product->id,
                'qty'        => $line->qty,
                'line_total' => self::money($line->line_total),
            ] : null,
            'voucher' => $voucher ? [
                'code'    => $voucher->code,
                'percent' => (int) $voucher->discount_percent,
            ] : null,
            'summary' => [
                'subtotal' => self::money($summary['subtotal']),
                'discount' => '-' . self::money($summary['discount']),
                'shipping' => self::money($summary['shipping']),
                'total'    => self::money($summary['total']),
            ],
        ];
    }
}
