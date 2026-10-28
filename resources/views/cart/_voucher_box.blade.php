{{-- Ô nhập mã giảm giá (dùng JS trong cart.js) --}}
<div class="voucher-input-row">
    <input type="text" class="js-voucher-input" placeholder="Nhập mã giảm giá" maxlength="50"
           value="{{ $voucher->code ?? '' }}" autocomplete="off">
    <button type="button" class="btn-soft js-apply-voucher">Áp dụng</button>
</div>
<div class="voucher-applied js-voucher-applied {{ $voucher ? 'show' : '' }}">
    <span><i class="bi bi-ticket-perforated me-1"></i>
        <span class="js-voucher-applied-text">{{ $voucher ? $voucher->code . ' (-' . $voucher->discount_percent . '%)' : '' }}</span></span>
    <button type="button" class="js-remove-voucher" title="Bỏ mã"><i class="bi bi-x-lg"></i></button>
</div>
<div class="voucher-msg js-voucher-msg"></div>
