<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Providers\CartService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Áp dụng mã giảm giá (khách gõ mã hoặc bấm chọn trong danh sách)
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ], [
            'code.required' => 'Vui lòng nhập hoặc chọn mã giảm giá.',
        ]);

        $code = strtoupper(trim($request->code));

        // Kiểm tra mã có trong CSDL và còn lượt dùng
        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại.'], 422);
        }

        if ($voucher->quantity <= 0) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá đã hết lượt sử dụng.'], 422);
        }

        if (CartService::subtotal() <= 0) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng đang trống.'], 422);
        }

        session(['voucher' => $voucher->code]);

        return response()->json(array_merge(
            ['success' => true, 'message' => 'Áp dụng mã ' . $voucher->code . ' thành công! Giảm ' . $voucher->discount_percent . '%.'],
            CartService::summary()
        ));
    }

    // Bỏ mã giảm giá
    public function remove()
    {
        session()->forget('voucher');

        return response()->json(array_merge(
            ['success' => true, 'message' => 'Đã bỏ mã giảm giá.'],
            CartService::summary()
        ));
    }
}
