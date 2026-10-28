@extends('layouts.app')

@section('title', 'Thanh toán - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
<div class="container cart-page">
    <h2 class="cart-title mb-4"><i class="bi bi-credit-card me-2"></i>Thanh toán</h2>

    <div class="row g-4">

        {{-- FORM THÔNG TIN NHẬN HÀNG + PHƯƠNG THỨC THANH TOÁN --}}
        <div class="col-lg-7">
            <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST" class="cart-box">
                @csrf

                <h5 class="fw-bold mb-3">Thông tin nhận hàng</h5>

                <div class="mb-3">
                    <label class="form-label">Họ tên người nhận</label>
                    <input type="text" name="shipping_name"
                        class="form-control @error('shipping_name') is-invalid @enderror"
                        value="{{ old('shipping_name', $user->name) }}">
                    @error('shipping_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="shipping_phone"
                        class="form-control @error('shipping_phone') is-invalid @enderror"
                        value="{{ old('shipping_phone', $user->phone) }}">
                    @error('shipping_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Địa chỉ nhận hàng</label>
                    <textarea name="shipping_address" rows="3"
                        class="form-control @error('shipping_address') is-invalid @enderror"
                        placeholder="Số nhà, đường, phường/xã, tỉnh/thành">{{ old('shipping_address', $user->address) }}</textarea>
                    @error('shipping_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <h5 class="fw-bold mb-3">Phương thức thanh toán</h5>

                <label class="pay-option">
                    <input type="radio" name="payment_method" value="COD"
                        {{ old('payment_method', 'COD') == 'COD' ? 'checked' : '' }}>
                    <strong>Thanh toán khi nhận hàng (COD)</strong>
                </label>

                <label class="pay-option">
                    <input type="radio" name="payment_method" value="VietQR"
                        {{ old('payment_method') == 'VietQR' ? 'checked' : '' }}>
                    <strong>Chuyển khoản VietQR</strong>
                    <div class="small text-muted ms-4">Mã QR sẽ hiện ở bước đặt hàng thành công.</div>
                </label>
                @error('payment_method') <div class="text-danger small">{{ $message }}</div> @enderror
            </form>
        </div>

        {{-- TÓM TẮT ĐƠN HÀNG --}}
        <div class="col-lg-5">
            <div class="cart-box">
                <h5 class="fw-bold mb-3">Đơn hàng của bạn</h5>

                @foreach($items as $item)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ asset($item['product']->image) }}" class="cart-img" style="width:60px;height:60px;"
                            alt="{{ $item['product']->name }}">
                        <div class="flex-grow-1">
                            <div class="cart-name">{{ $item['product']->name }}</div>
                            <small class="text-muted">
                                {{ number_format($item['price'], 0, ',', '.') }}đ x {{ $item['qty'] }}
                            </small>
                        </div>
                        <div class="fw-semibold">{{ number_format($item['line_total'], 0, ',', '.') }}đ</div>
                    </div>
                @endforeach

                <hr>

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
                    <strong>Tổng thanh toán</strong>
                    <span class="sum-total" id="sumTotal">{{ number_format($summary['total'], 0, ',', '.') }}đ</span>
                </div>

                {{-- Nút nằm ngoài <form> nên dùng thuộc tính form="checkoutForm" --}}
                <button type="submit" form="checkoutForm" class="btn btn-cart w-100 mt-2 py-3">
                    Đặt hàng
                </button>
                <a href="{{ route('cart.index') }}" class="btn btn-cart-outline w-100 mt-2">Quay lại giỏ hàng</a>
            </div>
        </div>
    </div>
</div>
@endsection
