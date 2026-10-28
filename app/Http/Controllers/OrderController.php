<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /* Lịch sử đơn hàng của khách đang đăng nhập */
    public function index()
    {
        $orders = Order::with('details.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('orders.index', compact('orders'));
    }

    /* Chi tiết đơn hàng (cũng là trang "Đặt hàng thành công") */
    public function show(Order $order)
    {
        abort_if($order->user_id !== Auth::id(), 404);

        $order->load('details.product');

        return view('orders.show', [
            'order'  => $order,
            'placed' => session('order_placed', false),
            'bank'   => config('aura.bank'),
        ]);
    }
}
