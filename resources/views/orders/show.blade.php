@extends('layouts.app')

@section('title', ($placed ? 'Đặt hàng thành công' : 'Đơn hàng #' . $order->code) . ' - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
@php use App\Services\CartService as Cart; @endphp
<div class="container cart-page">

    @if($placed)
        @include('checkout._steps', ['step' => 3])
        <div class="success-head">
            <div class="success-icon"><i class="bi bi-check-lg"></i></div>
            <h2 class="fw-bold" style="color:#4A3525;">Đặt hàng thành công!</h2>
            <p class="text-muted mb-0">Cảm ơn bạn đã mua hàng tại AURA FLORIST.</p>
        </div>
    @else
        <h1 class="cart-title">Đơn hàng #{{ $order->code }}</h1>
    @endif

    <div class="row g-4">

        {{-- Thông tin đơn hàng --}}
        <div class="col-lg-{{ $order->is_transfer ? '5' : '12' }}">
            <div class="cart-card">
                <div class="cart-card-title">Thông tin đơn hàng</div>
                <div class="info-line"><span>Mã đơn hàng</span><span>#{{ $order->code }}</span></div>
                <div class="info-line"><span>Ngày đặt hàng</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                <div class="info-line"><span>Tổng tiền</span><span>{{ Cart::money($order->total_price) }}</span></div>
                <div class="info-line"><span>Phương thức thanh toán</span><span>{{ $order->payment_label }}</span></div>
                <div class="info-line"><span>Trạng thái</span><span><span class="status-chip {{ $order->status_class }}">{{ $order->status_label }}</span></span></div>
                <div class="info-line"><span>Người nhận</span><span>{{ $order->shipping_name }} - {{ $order->shipping_phone }}</span></div>
                <div class="info-line"><span>Địa chỉ</span><span style="white-space:pre-line;">{{ $order->shipping_address }}</span></div>
            </div>
        </div>

        {{-- Chuyển khoản VietQR --}}
        @if($order->is_transfer)
            <div class="col-lg-7">
                <div class="cart-card">
                    <div class="cart-card-title">Thông tin chuyển khoản</div>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-7">
                            <div class="info-line"><span>Ngân hàng</span><span>{{ $bank['bank_name'] }}</span></div>
                            <div class="info-line"><span>Chủ tài khoản</span><span>{{ $bank['account_name'] }}</span></div>
                            <div class="info-line"><span>Số tài khoản</span><span>{{ $bank['account_number'] }}</span></div>
                            <div class="info-line"><span>Số tiền</span><span>{{ Cart::money($order->total_price) }}</span></div>
                            <div class="info-line"><span>Nội dung CK</span><span>{{ $order->code }}</span></div>
                            <button type="button" class="btn-soft mt-3 js-copy" data-copy="{{ $order->code }}">
                                <i class="bi bi-clipboard me-1"></i>Sao chép nội dung
                            </button>
                        </div>
                        <div class="col-md-5 text-center">
                            <img class="qr-img" src="{{ asset($bank['qr_image']) }}" alt="Mã VietQR">
                            <div class="bank-note mt-1">VietQR • napas 24/7</div>
                        </div>
                    </div>
                    <p class="bank-note mt-3 mb-0">
                        Vui lòng quét mã QR hoặc chuyển khoản theo thông tin trên, nhập số tiền và nội dung
                        <strong>{{ $order->code }}</strong>. Sau khi thanh toán, đơn hàng sẽ được xác nhận và xử lý sớm nhất.
                    </p>
                </div>
            </div>
        @endif

        {{-- Sản phẩm --}}
        <div class="col-12">
            <div class="cart-card">
                <div class="cart-card-title">Sản phẩm đã đặt</div>
                @foreach($order->details as $d)
                    @php
                        $p = $d->product;
                        $img = $p ? (\Illuminate\Support\Str::startsWith($p->image, 'http') ? $p->image : asset($p->image)) : '';
                    @endphp
                    <div class="order-item">
                        @if($img)<img src="{{ $img }}" alt="">@endif
                        <div class="flex-fill">{{ $p->name ?? 'Sản phẩm đã ngừng bán' }}
                            <div class="order-meta">{{ Cart::money($d->price) }} × {{ $d->quantity }}</div>
                        </div>
                        <div class="fw-bold">{{ Cart::money($d->line_total) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3 mt-4 justify-content-center">
        <a href="{{ route('orders') }}" class="btn-soft text-decoration-none">Lịch sử đơn hàng</a>
        <a href="{{ route('products.all') }}" class="btn-brown w-auto px-4">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
