<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cart;

    public function __construct(CartService $cart)
    {
        $this->cart = $cart;
    }

    /* Trang giỏ hàng */
    public function index()
    {
        $lines   = $this->cart->lines('cart');
        $voucher = $this->cart->appliedVoucher();
        $summary = $this->cart->summary($lines, $voucher);

        return view('cart.index', compact('lines', 'voucher', 'summary'));
    }

    /* AJAX: nhận product_id + số lượng từ nút "Thêm vào giỏ" */
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty'        => 'nullable|integer|min:1|max:' . $this->cart->maxQty(),
        ], [
            'product_id.required' => 'Thiếu mã sản phẩm.',
            'product_id.exists'   => 'Sản phẩm không tồn tại.',
            'qty.integer'         => 'Số lượng không hợp lệ.',
            'qty.min'             => 'Số lượng tối thiểu là 1.',
            'qty.max'             => 'Số lượng tối đa là ' . $this->cart->maxQty() . '.',
        ]);

        $this->cart->add((int) $data['product_id'], (int) ($data['qty'] ?? 1));

        $product = Product::find($data['product_id']);

        return response()->json($this->cart->payload(
            'cart',
            null,
            'Đã thêm "' . $product->name . '" vào giỏ hàng!'
        ));
    }

    /* AJAX: tăng / giảm / nhập số lượng */
    public function update(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'qty'        => 'required|integer|min:1|max:' . $this->cart->maxQty(),
            'mode'       => 'nullable|string',
        ], [
            'qty.required' => 'Vui lòng nhập số lượng.',
            'qty.integer'  => 'Số lượng không hợp lệ.',
            'qty.min'      => 'Số lượng tối thiểu là 1.',
            'qty.max'      => 'Số lượng tối đa là ' . $this->cart->maxQty() . '.',
        ]);

        $mode = $this->cart->normalizeMode($data['mode'] ?? null);

        $this->cart->setQty((int) $data['product_id'], (int) $data['qty'], $mode);

        return response()->json($this->cart->payload($mode, (int) $data['product_id']));
    }

    /* AJAX: xóa sản phẩm khỏi giỏ */
    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'mode'       => 'nullable|string',
        ]);

        $mode = $this->cart->normalizeMode($data['mode'] ?? null);

        $this->cart->remove((int) $data['product_id'], $mode);

        return response()->json($this->cart->payload($mode, null, 'Đã xóa sản phẩm khỏi giỏ hàng.'));
    }

    /* AJAX: áp mã giảm giá (lấy từ bảng vouchers) */
    public function applyVoucher(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:50',
            'mode' => 'nullable|string',
        ], [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
            'code.max'      => 'Mã giảm giá không hợp lệ.',
        ]);

        $mode = $this->cart->normalizeMode($data['mode'] ?? null);

        [$ok, $message] = $this->cart->applyVoucher($data['code'], $this->cart->lines($mode));

        $payload = $this->cart->payload($mode, null, $message);
        $payload['success'] = $ok;

        return response()->json($payload, $ok ? 200 : 422);
    }

    /* AJAX: bỏ mã giảm giá */
    public function removeVoucher(Request $request)
    {
        $mode = $this->cart->normalizeMode($request->input('mode'));

        $this->cart->forgetVoucher();

        return response()->json($this->cart->payload($mode, null, 'Đã bỏ mã giảm giá.'));
    }
}
