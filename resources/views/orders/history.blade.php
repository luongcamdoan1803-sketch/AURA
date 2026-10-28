@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container cart-page">
    <h2 class="cart-title mb-4"><i class="bi bi-receipt me-2"></i>Đơn hàng của tôi</h2>

    @forelse($orders as $order)
        <div class="order-card">
            <div class="order-card-head">
                <div>
                    <strong>Đơn #{{ $order->id }}</strong>
                    <span class="text-muted ms-2">{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</span>
                </div>
                <span class="status-badge status-{{ $order->status }}">{{ $order->status_text }}</span>
            </div>

            <div class="order-card-body">
                @foreach($order->details as $d)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @if($d->product)
                            <img src="{{ asset($d->product->image) }}" class="cart-img" style="width:60px;height:60px;"
                                alt="{{ $d->product->name }}">
                        @endif
                        <div class="flex-grow-1">
                            <div class="cart-name">{{ $d->product->name ?? 'Sản phẩm đã xóa' }}</div>
                            <small class="text-muted">{{ number_format($d->price, 0, ',', '.') }}đ x {{ $d->quantity }}</small>
                        </div>
                        <div class="fw-semibold">{{ number_format($d->price * $d->quantity, 0, ',', '.') }}đ</div>
                    </div>
                @endforeach

                <hr>
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="small text-muted">
                        Giao đến: {{ $order->shipping_name }} - {{ $order->shipping_phone }}<br>
                        {{ $order->shipping_address }}<br>
                        Thanh toán: {{ $order->payment_method == 'COD' ? 'COD' : 'VietQR' }}
                    </div>
                    <div class="text-end">
                        <div>Tổng tiền</div>
                        <div class="sum-total">{{ number_format($order->total_price, 0, ',', '.') }}đ</div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="cart-box text-center py-5">
            <i class="bi bi-bag" style="font-size: 4rem; color: #C5AB88;"></i>
            <p class="mt-3 mb-4">Bạn chưa có đơn hàng nào.</p>
            <a href="{{ route('products.all') }}" class="btn btn-cart">Mua hoa ngay</a>
        </div>
    @endforelse
</div>
@endsection
