@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
@php use App\Services\CartService as Cart; @endphp
<div class="container cart-page">

    <h1 class="cart-title">Lịch sử đơn hàng</h1>

    @forelse($orders as $order)
        <div class="order-card">
            <div class="order-card-head">
                <div>
                    <span class="order-code">#{{ $order->code }}</span>
                    <span class="order-meta ms-2">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <span class="status-chip {{ $order->status_class }}">{{ $order->status_label }}</span>
            </div>

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
                </div>
            @endforeach

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mt-2 pt-2" style="border-top:1px solid #EADFD0;">
                <div class="order-meta">{{ $order->payment_label }}</div>
                <div>
                    <strong class="me-3">Tổng: {{ Cart::money($order->total_price) }}</strong>
                    <a href="{{ route('orders.show', $order) }}" class="btn-soft text-decoration-none">Xem chi tiết</a>
                </div>
            </div>
        </div>
    @empty
        <div class="cart-card empty-state">
            <i class="bi bi-bag"></i>
            <h5 class="mt-3 fw-bold" style="color:#4A3525;">Bạn chưa có đơn hàng nào</h5>
            <a href="{{ route('products.all') }}" class="btn-brown d-inline-block w-auto px-4 mt-2">Mua sắm ngay</a>
        </div>
    @endforelse

    <div class="d-flex justify-content-center">{{ $orders->links('pagination::bootstrap-5') }}</div>
</div>
@endsection
