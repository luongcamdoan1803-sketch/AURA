<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Voucher;

class CartService
{
    // Giá bán thật = giá gốc trừ % giảm của sản phẩm
    public static function finalPrice($product)
    {
        return (int) round($product->price * (100 - $product->discount_percent) / 100);
    }

    // Tổng số lượng hoa trong giỏ (hiện trên icon giỏ hàng)
    public static function count()
    {
        return (int) array_sum(session('cart', []));
    }

    // Lấy danh sách sản phẩm trong giỏ (kèm thông tin từ CSDL)
    public static function items()
    {
        $cart = session('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        foreach ($cart as $id => $qty) {
            if (!isset($products[$id])) {
                continue; // sản phẩm đã bị xóa khỏi CSDL
            }
            $product = $products[$id];
            $price = self::finalPrice($product);

            $items[] = [
                'product'    => $product,
                'qty'        => $qty,
                'price'      => $price,
                'line_total' => $price * $qty,
            ];
        }

        return $items;
    }

    // Tạm tính (chưa giảm giá)
    public static function subtotal()
    {
        $sum = 0;
        foreach (self::items() as $item) {
            $sum += $item['line_total'];
        }
        return $sum;
    }

    // Voucher đang áp dụng (null nếu chưa có hoặc đã hết lượt)
    public static function voucher()
    {
        $code = session('voucher');
        if (!$code) {
            return null;
        }

        $voucher = Voucher::where('code', $code)->where('quantity', '>', 0)->first();
        if (!$voucher) {
            session()->forget('voucher');
        }

        return $voucher;
    }

    // Số tiền được giảm
    public static function discount()
    {
        $voucher = self::voucher();
        if (!$voucher) {
            return 0;
        }
        return (int) round(self::subtotal() * $voucher->discount_percent / 100);
    }

    // Thành tiền phải trả
    public static function total()
    {
        return self::subtotal() - self::discount();
    }

    // Dữ liệu tóm tắt trả về cho AJAX
    public static function summary()
    {
        $voucher = self::voucher();

        return [
            'count'            => self::count(),
            'subtotal'         => self::subtotal(),
            'discount'         => self::discount(),
            'total'            => self::total(),
            'voucher_code'     => $voucher ? $voucher->code : null,
            'voucher_percent'  => $voucher ? $voucher->discount_percent : 0,
        ];
    }
}
