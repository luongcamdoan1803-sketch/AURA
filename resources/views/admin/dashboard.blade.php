@extends('admin.layouts.app')

@section('title', 'Bảng Điều Khiển & Thống Kê Doanh Thu')
@section('header_title', 'Báo Cáo Tổng Quan & Thống Kê Doanh Thu')

@section('content')
<!-- LỜI CHÀO & TỔNG QUAN -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">
            Xin chào, {{ Auth::user()->name ?? 'Admin' }}!
        </h4>
        <p class="text-muted small mb-0">Hệ thống ghi nhận và tổng hợp dữ liệu doanh thu thời gian thực từ cửa hàng AURA Florist</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-outline-secondary position-relative">
            <i class="fa-solid fa-bell me-1"></i> Đơn chờ duyệt
            @if($pendingOrders > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $pendingOrders }}
                </span>
            @endif
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-aura shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Thêm hoa mới
        </a>
    </div>
</div>

<!-- 4 THẺ CHỈ SỐ KPI CHÍNH -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Tổng doanh thu hoàn tất</div>
                <div class="stat-value text-success">{{ number_format($completedRevenue, 0, ',', '.') }} <small style="font-size: 1rem;">đ</small></div>
                <div class="text-muted small mt-1">
                    <i class="fa-solid fa-circle-info me-1"></i> Tạm tính: {{ number_format($allActiveRevenue, 0, ',', '.') }} đ
                </div>
            </div>
            <div class="stat-icon revenue shadow-sm">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Tổng số đơn hàng</div>
                <div class="stat-value text-primary">{{ $totalOrders }}</div>
                <div class="text-muted small mt-1">
                    <span class="text-warning fw-semibold">{{ $pendingOrders }} chờ duyệt</span> • {{ $completedOrders }} thành công
                </div>
            </div>
            <div class="stat-icon orders shadow-sm">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Sản phẩm hoa trong kho</div>
                <div class="stat-value" style="color: #C53030;">{{ $totalProducts }}</div>
                <div class="text-muted small mt-1">
                    Phân bổ trong <strong>{{ $totalCategories }}</strong> danh mục hoa
                </div>
            </div>
            <div class="stat-icon products shadow-sm">
                <i class="fa-solid fa-spa"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div>
                <div class="stat-label">Khách hàng thành viên</div>
                <div class="stat-value" style="color: #805AD5;">{{ $totalCustomers }}</div>
                <div class="text-muted small mt-1">
                    Tài khoản đã đăng ký mua hàng
                </div>
            </div>
            <div class="stat-icon users shadow-sm">
                <i class="fa-solid fa-user-group"></i>
            </div>
        </div>
    </div>
</div>

<!-- TIÊU CHÍ 1: THỐNG KÊ DOANH THU THEO LOẠI SẢN PHẨM (DANH MỤC) -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fa-solid fa-chart-pie me-2 text-muted"></i>1. Thống Kê Doanh Thu Theo Loại Sản Phẩm (Danh Mục Hoa)
        </h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Tên danh mục hoa</th>
                        <th class="text-center">Số mẫu hoa</th>
                        <th class="text-center">Số lượng đã bán</th>
                        <th class="text-end">Doanh thu thu về</th>
                        <th style="width: 250px;">Tỷ trọng doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $maxRev = $categoryStats->max('revenue') ?: 1;
                    @endphp
                    @forelse($categoryStats as $cat)
                        @php
                            $percentage = $allActiveRevenue > 0 ? round(($cat['revenue'] / $allActiveRevenue) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">{{ $cat['name'] }}</span>
                            </td>
                            <td class="text-center">
                                {{ $cat['product_count'] }}
                            </td>
                            <td class="text-center">
                                {{ $cat['sold_count'] }}
                            </td>
                            <td class="text-end fw-bold text-danger">
                                {{ number_format($cat['revenue'], 0, ',', '.') }} đ
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%; background-color: var(--aura-primary);" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="small fw-semibold text-muted" style="width: 45px;">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Chưa có dữ liệu danh mục.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- TIÊU CHÍ 2: THỐNG KÊ THEO SẢN PHẨM (TOP BÁN CHẠY NHẤT) -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fa-solid fa-ranking-star me-2 text-muted"></i>2. Top Hoa Bán Chạy Nhất (Theo Sản Phẩm)
                </h5>
            </div>
            <div class="admin-card-body p-0">
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Ảnh</th>
                                <th>Tên sản phẩm hoa</th>
                                <th class="text-center">Đã bán</th>
                                <th class="text-end">Doanh số</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $item)
                                @php
                                    $p = $item['product'];
                                    $imgSrc = file_exists(public_path('images/' . $p->image)) 
                                        ? asset('images/' . $p->image) 
                                        : asset('images/default.jpg');
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ $imgSrc }}" alt="{{ $p->name }}" class="flower-thumb" style="width: 44px; height: 44px;" onerror="this.src='https://placehold.co/44x44?text=AURA';">
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark small">{{ $p->name }}</div>
                                        <span class="badge bg-light text-muted border" style="font-size: 0.7rem;">{{ $p->category->name ?? '—' }}</span>
                                    </td>
                                    <td class="text-center fw-bold text-success">
                                        {{ $item['quantity_sold'] }}
                                    </td>
                                    <td class="text-end fw-semibold text-danger small">
                                        {{ number_format($item['total_revenue'], 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Chưa có dữ liệu đơn hàng.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- TIÊU CHÍ 3: THỐNG KÊ THEO KHÁCH HÀNG (TOP CHI TIÊU NHIỀU NHẤT) -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title">
                    <i class="fa-solid fa-crown me-2 text-muted"></i>3. Khách Hàng Tiềm Năng (Theo Khách Hàng)
                </h5>
            </div>
            <div class="admin-card-body p-0">
                <div class="admin-table-container">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th class="text-center">Số đơn mua</th>
                                <th class="text-end">Tổng tiền chi tiêu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topCustomers as $item)
                                @php $u = $item['user']; @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark small">{{ $u->name }}</div>
                                        <div class="text-muted" style="font-size: 0.72rem;">{{ $u->email }}</div>
                                    </td>
                                    <td class="text-center">
                                        {{ $item['order_count'] }}
                                    </td>
                                    <td class="text-end fw-bold text-danger small">
                                        {{ number_format($item['total_spent'], 0, ',', '.') }} đ
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Chưa có khách hàng nào đặt đơn.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ĐƠN HÀNG MỚI NHẤT CẦN XỬ LÝ -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fa-solid fa-bell me-2 text-muted"></i>Đơn hàng mới nhất cần duyệt
        </h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
            Xem tất cả đơn hàng <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Thời gian</th>
                        <th>Thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Duyệt nhanh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-decoration-none" style="color: var(--aura-primary-dark);">
                                    #{{ $order->code }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $order->shipping_name }}</div>
                                <small class="text-muted">{{ $order->shipping_phone }}</small>
                            </td>
                            <td>
                                <small class="text-muted">{{ $order->created_at ? $order->created_at->diffForHumans() : '—' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $order->payment_method === 'COD' ? 'COD' : 'VietQR' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-aura py-1 px-2">
                                    <i class="fa-solid fa-eye"></i> Xem & Xử lý
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Chưa có đơn hàng nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
