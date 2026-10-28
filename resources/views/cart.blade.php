@extends('layouts.app')

@section('title', 'Giỏ hàng - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container cart-page">
    <h2 class="cart-title mb-4"><i class="bi bi-cart3 me-2"></i>Giỏ hàng của bạn</h2>

    @if(session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
    @endif

    @if(count($items) == 0)
        {{-- GIỎ HÀNG TRỐNG --}}
        <div class="cart-box text-center py-5">
            <i class="bi bi-cart-x" style="font-size: 4rem; color: #C5AB88;"></i>
            <p class="mt-3 mb-4">Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.all') }}" class="btn btn-cart">Tiếp tục mua sắm</a>
        </div>
    @else
        <div class="row g-4">

            {{-- DANH SÁCH SẢN PHẨM --}}
            <div class="col-lg-8">
                <div class="cart-box">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr id="row-{{ $item['product']->id }}" data-id="{{ $item['product']->id }}">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset($item['product']->image) }}" class="cart-img"
                                                    alt="{{ $item['product']->name }}">
                                                <span class="cart-name">{{ $item['product']->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="cart-price">{{ number_format($item['price'], 0, ',', '.') }}đ</div>
                                            @if($item['product']->discount_percent > 0)
                                                <div class="cart-old-price">{{ number_format($item['product']->price, 0, ',', '.') }}đ</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="qty-box">
                                                <button type="button" class="qty-minus">-</button>
                                                <input type="number" class="qty-input" value="{{ $item['qty'] }}" min="1" max="99">
                                                <button type="button" class="qty-plus">+</button>
                                            </div>
                                        </td>
                                        <td class="fw-semibold line-total">{{ number_format($item['line_total'], 0, ',', '.') }}đ</td>
                                        <td>
                                            <button type="button" class="cart-remove"><i class="bi bi-trash"></i> Xóa</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a href="{{ route('products.all') }}" class="btn btn-cart-outline mt-3">
                    <i class="bi bi-arrow-left"></i> Tiếp tục mua sắm
                </a>
            </div>

            {{-- VOUCHER + TỔNG TIỀN --}}
            <div class="col-lg-4">
                <div class="cart-box">
                    @include('partials.voucher-box')

                    <div class="sum-row">
                        <span>Tạm tính</span>
                        <span id="sumSubtotal">{{ number_format($summary['subtotal'], 0, ',', '.') }}đ</span>
                    </div>
                    <div class="sum-row text-success" id="rowDiscount"
                        style="{{ $summary['discount'] > 0 ? '' : 'display:none;' }}">
                        <span>Giảm giá <small id="appliedVoucher">@if($summary['voucher_code']){{ $summary['voucher_code'] }} (-{{ $summary['voucher_percent'] }}%)@endif</small></span>
                        <span id="sumDiscount">-{{ number_format($summary['discount'], 0, ',', '.') }}đ</span>
                    </div>
                    <hr>
                    <div class="sum-row">
                        <strong>Tổng cộng</strong>
                        <span class="sum-total" id="sumTotal">{{ number_format($summary['total'], 0, ',', '.') }}đ</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-cart w-100 mt-2 py-3">
                        Tiến hành thanh toán
                    </a>
                    @guest
                        <div class="small text-muted text-center mt-2">Bạn cần đăng nhập để đặt hàng.</div>
                    @endguest
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
