@extends('layouts.app')

@section('title', 'Giỏ hàng - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container cart-page" data-cart-root data-mode="cart">

    <h1 class="cart-title">Giỏ hàng</h1>

    @if(session('error'))
        <div class="alert alert-warning rounded-3">{{ session('error') }}</div>
    @endif

    {{-- Giỏ trống --}}
    <div class="cart-card empty-state js-empty {{ $lines->isEmpty() ? '' : 'd-none' }}">
        <i class="bi bi-cart-x"></i>
        <h5 class="mt-3 fw-bold" style="color:#4A3525;">Giỏ hàng của bạn đang trống</h5>
        <p>Hãy chọn vài bó hoa thật xinh để gửi tặng người thân nhé.</p>
        <a href="{{ route('products.all') }}" class="btn-brown d-inline-block w-auto px-4">Đến cửa hàng</a>
    </div>

    <div class="js-filled {{ $lines->isEmpty() ? 'd-none' : '' }}">
        <div class="row g-4">

            {{-- Danh sách sản phẩm --}}
            <div class="col-lg-8">
                <div class="cart-card">
                    <div class="cart-head">
                        <div>Sản phẩm</div>
                        <div>Giá</div>
                        <div>Số lượng</div>
                        <div>Tổng</div>
                        <div class="text-center">Thao tác</div>
                    </div>

                    @foreach($lines as $line)
                        @php
                            $p = $line->product;
                            $img = \Illuminate\Support\Str::startsWith($p->image, 'http') ? $p->image : asset($p->image);
                        @endphp
                        <div class="cart-row" data-line data-id="{{ $p->id }}">
                            <div class="cart-prod">
                                <a href="{{ route('shop.detail', $p->id) }}"><img src="{{ $img }}" alt="{{ $p->name }}"></a>
                                <div>
                                    <a href="{{ route('shop.detail', $p->id) }}" class="cart-prod-name">{{ $p->name }}</a>
                                    <div class="cart-prod-cat">{{ $p->category->name ?? 'Hoa tươi' }}</div>
                                </div>
                            </div>
                            <div class="cart-price">
                                {{ \App\Services\CartService::money($line->unit_price) }}
                                @if((int) $p->discount_percent > 0)
                                    <span class="price-old">{{ \App\Services\CartService::money($p->price) }}</span>
                                @endif
                            </div>
                            <div class="cart-qty">@include('cart._qty', ['qty' => $line->qty])</div>
                            <div class="cart-total js-line-total">{{ \App\Services\CartService::money($line->line_total) }}</div>
                            <div class="cart-action text-center">
                                <button type="button" class="btn-trash js-remove" title="Xóa"><i class="bi bi-trash3"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('products.all') }}" class="link-back">← Tiếp tục mua sắm</a>
            </div>

            {{-- Tổng tiền --}}
            <div class="col-lg-4">
                <div class="cart-card">
                    <div class="cart-card-title">Tổng tiền</div>

                    <div class="sum-row"><span>Tạm tính</span><span class="js-subtotal">{{ \App\Services\CartService::money($summary['subtotal']) }}</span></div>
                    <div class="sum-row sum-discount js-discount-row {{ $voucher ? '' : 'd-none' }}"><span>Giảm giá</span><span class="js-discount">-{{ \App\Services\CartService::money($summary['discount']) }}</span></div>
                    <div class="sum-row"><span>Phí vận chuyển</span><span class="js-shipping">{{ \App\Services\CartService::money($summary['shipping']) }}</span></div>
                    <div class="sum-row sum-total"><span>Thành tiền</span><span class="js-total">{{ \App\Services\CartService::money($summary['total']) }}</span></div>

                    <div class="mt-3">
                        <div class="form-label-aura">Mã giảm giá</div>
                        @include('cart._voucher_box', ['voucher' => $voucher])
                    </div>

                    <a href="{{ route('checkout') }}" class="btn-brown mt-3">Thanh toán</a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
