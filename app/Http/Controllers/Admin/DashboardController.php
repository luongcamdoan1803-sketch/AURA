<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Báo cáo Thống kê Doanh thu & Tổng quan hệ thống (Sử dụng 100% Eloquent ORM)
     * Thống kê theo: Loại sản phẩm (Category), Sản phẩm (Product), và Khách hàng (User)
     */
    public function index()
    {
        // 1. CÁC CHỈ SỐ TỔNG QUAN (KPIs)
        $completedRevenue = Order::where('status', 'completed')->sum('total_price');
        $allActiveRevenue = Order::where('status', '!=', 'cancelled')->sum('total_price');
        
        $totalOrders     = Order::count();
        $pendingOrders   = Order::where('status', 'pending')->count();
        $processingOrders= Order::where('status', 'processing')->count();
        $shippingOrders  = Order::where('status', 'shipping')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();

        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalCustomers  = User::where(function ($q) {
            $q->where('role', 0)->orWhere('role', 'customer');
        })->count();

        // 2. TIÊU CHÍ 1: THỐNG KÊ DOANH THU THEO LOẠI SẢN PHẨM (DANH MỤC HOA)
        $categoryStats = Category::with(['products.orderDetails' => function ($q) {
            $q->whereHas('order', function ($o) {
                $o->where('status', '!=', 'cancelled');
            });
        }])->get()->map(function ($cat) {
            $soldCount = 0;
            $revenue = 0;
            foreach ($cat->products as $product) {
                foreach ($product->orderDetails as $detail) {
                    $soldCount += $detail->quantity;
                    $revenue   += ($detail->price * $detail->quantity);
                }
            }
            return [
                'name'          => $cat->name,
                'slug'          => $cat->slug,
                'product_count' => $cat->products->count(),
                'sold_count'    => $soldCount,
                'revenue'       => $revenue,
            ];
        })->sortByDesc('revenue')->values();

        // 3. TIÊU CHÍ 2: THỐNG KÊ THEO SẢN PHẨM HOA (TOP BÁN CHẠY NHẤT & DOANH THU CAO NHẤT)
        $topProducts = Product::with(['category', 'orderDetails' => function ($q) {
            $q->whereHas('order', function ($o) {
                $o->where('status', '!=', 'cancelled');
            });
        }])->get()->map(function ($product) {
            $quantitySold = $product->orderDetails->sum('quantity');
            $totalRev     = $product->orderDetails->sum(function ($d) {
                return $d->price * $d->quantity;
            });
            return [
                'product'       => $product,
                'quantity_sold' => $quantitySold,
                'total_revenue' => $totalRev,
            ];
        })->sortByDesc('quantity_sold')->take(5)->values();

        // 4. TIÊU CHÍ 3: THỐNG KÊ DOANH THU THEO KHÁCH HÀNG (TOP KHÁCH HÀNG MUA NHIỀU NHẤT)
        $topCustomers = User::with(['orders' => function ($q) {
            $q->where('status', '!=', 'cancelled');
        }])->get()->map(function ($user) {
            $orderCount = $user->orders->count();
            $totalSpent = $user->orders->sum('total_price');
            return [
                'user'        => $user,
                'order_count' => $orderCount,
                'total_spent' => $totalSpent,
            ];
        })->filter(function ($c) {
            return $c['order_count'] > 0;
        })->sortByDesc('total_spent')->take(5)->values();

        // 5. DANH SÁCH ĐƠN HÀNG MỚI NHẤT CẦN DUYỆT
        $recentOrders = Order::with(['user', 'details.product'])
            ->latest('id')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'completedRevenue',
            'allActiveRevenue',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'shippingOrders',
            'completedOrders',
            'cancelledOrders',
            'totalProducts',
            'totalCategories',
            'totalCustomers',
            'categoryStats',
            'topProducts',
            'topCustomers',
            'recentOrders'
        ));
    }
}
