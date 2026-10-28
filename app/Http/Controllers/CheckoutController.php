<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /*
     * Trang thanh toán.
     *  - /thanh-toan                           : thanh toán các sản phẩm trong giỏ
     *  - /thanh-toan?product_id=..&qty=..      : "Mua ngay" (nhận product_id + số lượng)
     *  - /thanh-toan?mode=buynow               : trang thanh toán của "Mua ngay"
     */
    public function show(Request $request)
    {
        // Bấm "Mua ngay": lưu sản phẩm rồi chuyển sang trang thanh toán sạch
        if ($request->filled('product_id')) {
            $data = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'qty'        => 'nullable|integer|min:1|max:' . $this->cart->maxQty(),
            ]);

            $this->cart->buyNow((int) $data['product_id'], (int) ($data['qty'] ?? 1));

            return redirect()->route('checkout', ['mode' => 'buynow']);
        }

        $mode  = $this->cart->normalizeMode($request->query('mode'));
        $lines = $this->cart->lines($mode);

        if ($mode === 'buynow' && $lines->isEmpty()) {
            return redirect()->route('checkout');
        }

        if ($lines->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống. Hãy chọn vài bó hoa nhé!');
        }

        $voucher  = $this->cart->appliedVoucher();
        $summary  = $this->cart->summary($lines, $voucher);
        $vouchers = Voucher::where('quantity', '>', 0)
            ->orderByDesc('discount_percent')
            ->get();

        return view('checkout.index', [
            'mode'     => $mode,
            'lines'    => $lines,
            'voucher'  => $voucher,
            'vouchers' => $vouchers,
            'summary'  => $summary,
            'user'     => Auth::user(),
        ]);
    }

    /* Xác nhận đặt hàng: lưu orders + order_details bằng Eloquent */
    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name'    => 'required|string|min:2|max:255',
            'shipping_phone'   => ['required', 'regex:/^(0|\+84)[3-9][0-9]{8}$/'],
            'shipping_address' => 'required|string|min:10|max:500',
            'note'             => 'nullable|string|max:255',
            'payment_method'   => 'required|in:COD,VietQR',
            'mode'             => 'nullable|string',
        ], [
            'shipping_name.required'    => 'Vui lòng nhập họ và tên người nhận.',
            'shipping_name.min'         => 'Họ và tên phải có ít nhất 2 ký tự.',
            'shipping_name.max'         => 'Họ và tên không được quá 255 ký tự.',
            'shipping_phone.required'   => 'Vui lòng nhập số điện thoại.',
            'shipping_phone.regex'      => 'Số điện thoại không hợp lệ (ví dụ: 0901234567).',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
            'shipping_address.min'      => 'Địa chỉ quá ngắn, vui lòng ghi rõ số nhà, đường, quận/huyện.',
            'shipping_address.max'      => 'Địa chỉ không được quá 500 ký tự.',
            'note.max'                  => 'Ghi chú không được quá 255 ký tự.',
            'payment_method.required'   => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in'         => 'Phương thức thanh toán không hợp lệ.',
        ]);

        $mode  = $this->cart->normalizeMode($data['mode'] ?? null);
        $lines = $this->cart->lines($mode);

        if ($lines->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Ghi chú không có cột riêng trong bảng orders nên được nối vào địa chỉ
        $address = trim($data['shipping_address']);
        if (!empty($data['note'])) {
            $address .= "\nGhi chú: " . trim($data['note']);
        }

        $order = DB::transaction(function () use ($data, $lines, $address) {
            // Khóa dòng voucher để 2 người không cùng dùng lượt cuối
            $voucher = null;
            $applied = $this->cart->appliedVoucher();

            if ($applied) {
                $voucher = Voucher::whereKey($applied->id)->lockForUpdate()->first();

                if (!$voucher || !$voucher->isAvailable()) {
                    $this->cart->forgetVoucher();

                    throw ValidationException::withMessages([
                        'voucher' => 'Mã giảm giá vừa hết lượt sử dụng, vui lòng kiểm tra lại đơn hàng.',
                    ]);
                }
            }

            $summary = $this->cart->summary($lines, $voucher);

            $order = Order::create([
                'user_id'          => Auth::id(),
                'total_price'      => $summary['total'],
                'shipping_name'    => trim($data['shipping_name']),
                'shipping_phone'   => $data['shipping_phone'],
                'shipping_address' => $address,
                'payment_method'   => $data['payment_method'],
                'status'           => 'pending',
            ]);

            foreach ($lines as $line) {
                $order->details()->create([
                    'product_id' => $line->product->id,
                    'quantity'   => $line->qty,
                    'price'      => $line->unit_price,
                ]);
            }

            if ($voucher) {
                $voucher->decrement('quantity');
            }

            return $order;
        });

        // Dọn giỏ hàng / mã giảm giá sau khi đặt thành công
        $this->cart->clear($mode);
        $this->cart->forgetVoucher();

        return redirect()
            ->route('orders.show', $order)
            ->with('order_placed', true);
    }
}
