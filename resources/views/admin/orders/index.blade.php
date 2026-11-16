@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn Hàng')
@section('header_title', 'Quản lý Đơn Hàng')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Quản Lý & Duyệt Đơn Hàng</h4>
        <p class="text-muted small mb-0">Tiếp nhận đơn hàng mới từ giỏ hàng & thanh toán để xác nhận, chuẩn bị hoa và điều phối giao hàng</p>
    </div>
</div>

<!-- THANH TAB TRẠNG THÁI NHANH -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.orders.index', ['status' => 'all', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status', 'all') === 'all' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Tất cả <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status') === 'pending' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Chờ xác nhận <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'processing', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status') === 'processing' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Đang xử lý <span class="badge bg-info text-white ms-1">{{ $counts['processing'] }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'shipping', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status') === 'shipping' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Đang giao hoa <span class="badge bg-primary text-white ms-1">{{ $counts['shipping'] }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'completed', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status') === 'completed' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Đã hoàn thành <span class="badge bg-success ms-1">{{ $counts['completed'] }}</span>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'cancelled', 'keyword' => request('keyword')]) }}" 
       class="btn btn-sm {{ request('status') === 'cancelled' ? 'btn-aura shadow-sm' : 'btn-outline-secondary' }}">
       Đã hủy <span class="badge bg-danger ms-1">{{ $counts['cancelled'] }}</span>
    </a>
</div>

<!-- TÌM KIẾM ĐƠN HÀNG -->
<div class="admin-card mb-4">
    <div class="admin-card-body p-3">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 align-items-center">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0" placeholder="Nhập mã đơn hàng (#AF...), tên người nhận hoặc số điện thoại..." value="{{ request('keyword') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-aura flex-grow-1">Tìm kiếm</button>
                @if(request()->filled('keyword'))
                    <a href="{{ route('admin.orders.index', ['status' => request('status', 'all')]) }}" class="btn btn-outline-secondary" title="Đặt lại"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- BẢNG DANH SÁCH ĐƠN HÀNG -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fa-solid fa-receipt me-2 text-muted"></i>Danh sách đơn hàng ({{ $orders->total() }})
        </h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Thời gian đặt</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tổng thanh toán</th>
                        <th>Trạng thái</th>
                        <th style="width: 170px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="fw-bold text-decoration-none" style="color: var(--aura-primary-dark);">
                                    #{{ $order->code }}
                                </a>
                                <div class="text-muted small">{{ $order->details->sum('quantity') }} bó/giỏ hoa</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $order->shipping_name }}</div>
                                <div class="text-muted small">
                                    <i class="fa-solid fa-phone me-1"></i>{{ $order->shipping_phone }}
                                </div>
                            </td>
                            <td>
                                <div class="text-dark small">{{ $order->created_at ? $order->created_at->format('d/m/Y') : '—' }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at ? $order->created_at->format('H:i') : '' }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $order->payment_method === 'COD' ? 'Thanh toán COD' : 'Chuyển khoản VietQR' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-danger fs-6">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 align-items-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-aura" title="Xem chi tiết & duyệt đơn">
                                        <i class="fa-solid fa-eye me-1"></i> Xem
                                    </a>

                                    <!-- Nút đổi trạng thái nhanh -->
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" title="Đổi trạng thái">
                                            <i class="fa-solid fa-sliders"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><span class="dropdown-item-text text-muted small">Chuyển trạng thái:</span></li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="dropdown-item small {{ $order->status === 'pending' ? 'active' : '' }}">Chờ xác nhận</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="processing">
                                                    <button type="submit" class="dropdown-item small {{ $order->status === 'processing' ? 'active' : '' }}">Đang xử lý</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="shipping">
                                                    <button type="submit" class="dropdown-item small {{ $order->status === 'shipping' ? 'active' : '' }}">Đang giao hàng</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="dropdown-item small text-success {{ $order->status === 'completed' ? 'active' : '' }}">Đã hoàn thành</button>
                                                </form>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item small text-danger">Hủy đơn</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-receipt fs-1 mb-3 text-secondary d-block"></i>
                                Không có đơn hàng nào trong mục này.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
        <div class="admin-card-footer p-3 border-top d-flex justify-content-end" style="background-color: var(--aura-bg);">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
