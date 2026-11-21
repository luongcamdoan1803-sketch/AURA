@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->code)
@section('header_title', 'Chi tiết đơn hàng #' . $order->code)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách đơn hàng
    </a>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">
                Đơn Hàng #{{ $order->code }}
            </h4>
            <div class="text-muted small">
                Thời gian đặt: {{ $order->created_at ? $order->created_at->format('d/m/Y - H:i:s') : '—' }}
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="status-badge status-{{ $order->status }} fs-6 px-3 py-2">
                <i class="fa-solid fa-circle-dot me-1"></i> {{ $order->status_label }}
            </span>
            <button onclick="window.print();" class="btn btn-outline-secondary btn-sm d-print-none">
                <i class="fa-solid fa-print me-1"></i> In hóa đơn
            </button>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title"><i class="fa-solid fa-sliders me-2 text-muted"></i>Xử lý & Duyệt đơn</h5>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <label class="form-label fw-semibold small text-muted text-uppercase">Cập nhật tiến độ đơn</label>
                    <select name="status" class="form-select mb-3">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Chờ xác nhận / Chờ thanh toán</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Đang xử lý (Đang cắm hoa & đóng gói)</option>
                        <option value="shipping" {{ $order->status === 'shipping' ? 'selected' : '' }}>Đang giao hàng (Shipper đang giao)</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Đã hoàn thành (Giao thành công)</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Hủy đơn hàng</option>
                    </select>

                    <button type="submit" class="btn btn-aura w-100">
                        <i class="fa-solid fa-check-double"></i> Cập nhật trạng thái
                    </button>
                </form>

                <hr class="my-4" style="border-color: var(--aura-border);">

                <div class="small">
                    <div class="text-muted mb-1">Phương thức thanh toán:</div>
                    <div class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-credit-card me-1 text-primary"></i>
                        {{ $order->payment_label }}
                    </div>

                    <div class="text-muted mb-1">Tài khoản khách hàng đặt:</div>
                    <div class="fw-semibold text-dark">
                        {{ $order->user->name ?? 'Khách vãng lai' }} 
                        <span class="text-muted">({{ $order->user->email ?? 'Không có email' }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- THÔNG TIN NGƯỜI NHẬN & ĐỊA CHỈ GIAO HÀNG -->
    <div class="col-lg-8">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h5 class="admin-card-title"><i class="fa-solid fa-location-dot me-2 text-muted"></i>Thông tin giao nhận hoa</h5>
            </div>
            <div class="admin-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-semibold d-block">Họ và tên người nhận:</span>
                        <span class="fs-6 fw-bold text-dark">{{ $order->shipping_name }}</span>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted small text-uppercase fw-semibold d-block">Số điện thoại liên hệ:</span>
                        <span class="fs-6 fw-bold text-dark">
                            <a href="tel:{{ $order->shipping_phone }}" class="text-decoration-none" style="color: var(--aura-primary);">
                                <i class="fa-solid fa-phone me-1"></i>{{ $order->shipping_phone }}
                            </a>
                        </span>
                    </div>

                    <div class="col-12">
                        <span class="text-muted small text-uppercase fw-semibold d-block">Địa chỉ giao hàng tận nơi:</span>
                        <div class="p-3 rounded mt-1" style="background-color: var(--aura-section); border: 1px solid var(--aura-border);">
                            <i class="fa-solid fa-truck-fast text-muted me-2"></i>
                            <span class="text-dark">{{ $order->shipping_address }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DANH SÁCH SẢN PHẨM HOA TRONG ĐƠN (ORDER DETAILS) -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title"><i class="fa-solid fa-box me-2 text-muted"></i>Danh sách hoa đặt mua ({{ $order->details->count() }} loại)</h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 80px;">Hình ảnh</th>
                        <th>Tên sản phẩm hoa</th>
                        <th>Danh mục</th>
                        <th class="text-center">Số lượng</th>
                        <th class="text-end">Đơn giá</th>
                        <th class="text-end">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $item)
                        <tr>
                            <td>
                                @php
                                    $imgSrc = $item->product ? $item->product->image_url : asset('images/about-flower.jpg');
                                @endphp
                                <img src="{{ $imgSrc }}" alt="{{ $item->product->name ?? 'Hoa' }}" class="flower-thumb" onerror="this.onerror=null; this.src='{{ asset('images/about-flower.jpg') }}';">
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->product->name ?? 'Sản phẩm đã bị xóa hoặc ngưng bán' }}</div>
                                @if($item->product && $item->product->style)
                                    <small class="text-muted">Kiểu dáng: {{ ucfirst($item->product->style) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $item->product->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="text-center fw-bold">{{ $item->quantity }}</td>
                            <td class="text-end">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td class="text-end fw-bold text-dark">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background-color: var(--aura-section);">
                        <td colspan="5" class="text-end fw-bold fs-6 py-3">Tổng cộng thanh toán:</td>
                        <td class="text-end fw-bold fs-5 text-danger py-3">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
