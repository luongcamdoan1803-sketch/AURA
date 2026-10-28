@extends('layouts.app')

@section('title', 'Thanh toán - AURA FLORIST')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush

@section('content')
@php use App\Services\CartService as Cart; @endphp
<div class="container cart-page" data-cart-root data-mode="{{ $mode }}"
     data-empty-redirect="{{ route('cart.index') }}">

    <h1 class="cart-title">Thanh toán</h1>
    @include('checkout._steps', ['step' => 2])

    @if($errors->has('voucher'))
        <div class="alert alert-danger rounded-3">{{ $errors->first('voucher') }}</div>
    @endif

    <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}" novalidate>
        @csrf
        <input type="hidden" name="mode" value="{{ $mode }}">

        <div class="row g-4">

            {{-- Sản phẩm trong đơn: tăng / giảm số lượng --}}
            <div class="col-12">
                <div class="cart-card">
                    <div class="cart-card-title">Sản phẩm trong đơn hàng</div>
                    @foreach($lines as $line)
                        @php
                            $p = $line->product;
                            $img = \Illuminate\Support\Str::startsWith($p->image, 'http') ? $p->image : asset($p->image);
                        @endphp
                        <div class="co-item" data-line data-id="{{ $p->id }}">
                            <a href="{{ route('shop.detail', $p->id) }}"><img src="{{ $img }}" alt="{{ $p->name }}"></a>
                            <div class="co-info">
                                <a href="{{ route('shop.detail', $p->id) }}" class="cart-prod-name">{{ $p->name }}</a>
                                <div class="cart-prod-cat">{{ Cart::money($line->unit_price) }} / sản phẩm</div>
                            </div>
                            @include('cart._qty', ['qty' => $line->qty])
                            <div class="co-line-total js-line-total">{{ Cart::money($line->line_total) }}</div>
                            @if($mode === 'cart')
                                <button type="button" class="btn-trash js-remove" title="Xóa"><i class="bi bi-trash3"></i></button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 1. Thông tin nhận hàng --}}
            <div class="col-lg-4">
                <div class="cart-card">
                    <div class="cart-card-title">1. Thông tin nhận hàng</div>

                    <div class="mb-3">
                        <label class="form-label-aura" for="shipping_name">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" id="shipping_name" name="shipping_name"
                               class="form-control form-control-aura @error('shipping_name') is-invalid @enderror"
                               value="{{ old('shipping_name', $user->name) }}" required minlength="2" maxlength="255">
                        <div class="invalid-feedback">{{ $errors->first('shipping_name') ?: 'Vui lòng nhập họ và tên (ít nhất 2 ký tự).' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-aura" for="shipping_phone">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" id="shipping_phone" name="shipping_phone"
                               class="form-control form-control-aura @error('shipping_phone') is-invalid @enderror"
                               value="{{ old('shipping_phone', $user->phone) }}" required
                               pattern="(0|\+84)[3-9][0-9]{8}" placeholder="0901234567">
                        <div class="invalid-feedback">{{ $errors->first('shipping_phone') ?: 'Số điện thoại không hợp lệ (ví dụ: 0901234567).' }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-aura" for="shipping_address">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" id="shipping_address" name="shipping_address"
                               class="form-control form-control-aura @error('shipping_address') is-invalid @enderror"
                               value="{{ old('shipping_address', $user->address) }}" required minlength="10" maxlength="500"
                               placeholder="Số nhà, đường, quận/huyện, tỉnh/thành">
                        <div class="invalid-feedback">{{ $errors->first('shipping_address') ?: 'Vui lòng nhập địa chỉ đầy đủ (ít nhất 10 ký tự).' }}</div>
                    </div>

                    <div>
                        <label class="form-label-aura" for="note">Ghi chú (tùy chọn)</label>
                        <textarea id="note" name="note" rows="3" maxlength="255"
                                  class="form-control form-control-aura @error('note') is-invalid @enderror"
                                  placeholder="Giao vào buổi sáng, vui lòng gọi trước khi giao">{{ old('note') }}</textarea>
                        <div class="invalid-feedback">{{ $errors->first('note') }}</div>
                    </div>
                </div>
            </div>

            {{-- 2. Chọn voucher --}}
            <div class="col-lg-4">
                <div class="cart-card">
                    <div class="cart-card-title">2. Chọn voucher</div>

                    @include('cart._voucher_box', ['voucher' => $voucher])

                    <div class="voucher-list">
                        @forelse($vouchers as $v)
                            <label class="voucher-option {{ $voucher && $voucher->id === $v->id ? 'active' : '' }}">
                                <input type="radio" name="voucher_pick" class="js-voucher-radio" value="{{ $v->code }}"
                                       {{ $voucher && $voucher->id === $v->id ? 'checked' : '' }}>
                                <div>
                                    <div class="voucher-code">{{ $v->code }}</div>
                                    <div class="voucher-desc">Giảm {{ $v->discount_percent }}% • Còn {{ $v->quantity }} lượt</div>
                                </div>
                            </label>
                        @empty
                            <div class="text-muted small">Hiện chưa có mã giảm giá nào.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 3. Phương thức thanh toán --}}
            <div class="col-lg-4">
                <div class="cart-card">
                    <div class="cart-card-title">3. Phương thức thanh toán</div>

                    @php $method = old('payment_method', 'COD'); @endphp

                    <label class="pay-option {{ $method === 'COD' ? 'active' : '' }}">
                        <input type="radio" class="js-pay-radio" name="payment_method" value="COD" {{ $method === 'COD' ? 'checked' : '' }} required>
                        <div>Thanh toán khi nhận hàng (COD)<small>Trả tiền mặt cho nhân viên giao hoa</small></div>
                    </label>

                    <label class="pay-option {{ $method === 'VietQR' ? 'active' : '' }}">
                        <input type="radio" class="js-pay-radio" name="payment_method" value="VietQR" {{ $method === 'VietQR' ? 'checked' : '' }}>
                        <div>Chuyển khoản ngân hàng<small>Quét mã VietQR sau khi đặt hàng</small></div>
                    </label>
                    @error('payment_method')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror

                    <div class="total-box">
                        <div class="sum-row"><span>Tạm tính</span><span class="js-subtotal">{{ Cart::money($summary['subtotal']) }}</span></div>
                        <div class="sum-row sum-discount js-discount-row {{ $voucher ? '' : 'd-none' }}"><span>Giảm giá</span><span class="js-discount">-{{ Cart::money($summary['discount']) }}</span></div>
                        <div class="sum-row"><span>Phí vận chuyển</span><span class="js-shipping">{{ Cart::money($summary['shipping']) }}</span></div>
                        <div class="sum-row sum-total"><span>Tổng (sau giảm giá)</span><span class="js-total">{{ Cart::money($summary['total']) }}</span></div>
                    </div>

                    <button type="submit" class="btn-brown mt-3 js-place-order">Đặt hàng</button>
                </div>
            </div>

        </div>
    </form>

    <a href="{{ $mode === 'cart' ? route('cart.index') : route('products.all') }}" class="link-back">
        ← {{ $mode === 'cart' ? 'Quay lại giỏ hàng' : 'Tiếp tục mua sắm' }}
    </a>
</div>
@endsection
