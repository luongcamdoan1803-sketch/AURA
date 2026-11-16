<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Danh sách tất cả đơn hàng từ khách hàng (kết nối dữ liệu từ bạn Trân)
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'details.product']);

        // Lọc theo trạng thái đơn hàng
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Tìm kiếm theo mã đơn hàng hoặc tên khách, số điện thoại
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                // Hỗ trợ tìm kiếm mã AF... hoặc số ID
                $cleanId = preg_replace('/[^0-9]/', '', $keyword);
                if (!empty($cleanId)) {
                    $q->orWhere('id', (int) $cleanId);
                }
                $q->orWhere('shipping_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('shipping_phone', 'LIKE', "%{$keyword}%");
            });
        }

        // Đếm số lượng đơn theo các trạng thái
        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipping'   => Order::where('status', 'shipping')->count(),
            'completed'  => Order::where('status', 'completed')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        $orders = $query->latest('id')->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    /**
     * Xem chi tiết một đơn hàng cụ thể
     */
    public function show($id)
    {
        $order = Order::with(['user', 'details.product.category'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái xử lý đơn hàng (Xác nhận, Xử lý, Đang giao, Hoàn thành, Hủy)
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ], [
            'status.required' => 'Vui lòng chọn trạng thái đơn hàng.',
            'status.in'       => 'Trạng thái đơn hàng không hợp lệ.',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->back()
            ->with('success', "Cập nhật trạng thái đơn hàng #{$order->code} sang '{$order->status_label}' thành công!");
    }
}
