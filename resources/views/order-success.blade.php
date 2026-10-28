@extends('layouts.app')

@section('title', 'Đặt hàng thành công - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container cart-page" style="max-width: 760px;">
    <div class="cart-box text-center mb-4">
        <i class="bi bi-check-circle-fill success-icon"></i>
        <h3 class="cart-title mt-2">Đặt hàng thành công!</h3>
        <p class="mb-0">Cảm ơn bạn đã mua hoa tại AURA FLORIST. Mã đơn hàng của bạn là <strong>#{{ $order->id }}</strong>.</p>
    </div>

    <div class="cart-box mb-4">
        <h5 class="fw-bold mb-3">Thông tin nhận hàng</h5>
        <p class="mb-1"><strong>Người nhận:</strong> {{ $order->shipping_name }}</p>
        <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->shipping_phone }}</p>
        <p class="mb-1"><strong>Địa chỉ:</strong> {{ $order->shipping_address }}</p>
        <p class="mb-0"><strong>Thanh toán:</strong>
            {{ $order->payment_method == 'COD' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản VietQR' }}
        </p>
    </div>

    <div class="cart-box mb-4">
        <h5 class="fw-bold mb-3">Sản phẩm đã đặt</h5>
        @foreach($order->details as $d)
            <div class="d-flex justify-content-between mb-2">
                <span>{{ $d->product->name ?? 'Sản phẩm đã xóa' }} x {{ $d->quantity }}</span>
                <span>{{ number_format($d->price * $d->quantity, 0, ',', '.') }}đ</span>
            </div>
        @endforeach
        <hr>
        <div class="sum-row">
            <strong>Tổng thanh toán</strong>
            <span class="sum-total">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
        </div>
    </div>

    {{-- Chỉ hiện khi chọn VietQR. SỬA số tài khoản / ngân hàng bên dưới thành của shop --}}
    @if($order->payment_method == 'VietQR')
        <div class="cart-box text-center mb-4">
            <h5 class="fw-bold mb-3">Quét mã để chuyển khoản</h5>
           <img src="{{ asset('images/vietqr.jpg') }}" alt="VietQR" style="max-width: 350px; height: auto;">
            <p class="small text-muted mt-2 mb-0">Nội dung chuyển khoản: <strong>AURA{{ $order->id }}</strong></p>
        </div>
    @endif

    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ route('orders') }}" class="btn btn-cart">Xem lịch sử đơn hàng</a>
        <a href="{{ route('products.all') }}" class="btn btn-cart-outline">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
