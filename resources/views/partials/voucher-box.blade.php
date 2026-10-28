{{-- Khung chọn mã giảm giá: dùng chung cho trang giỏ hàng và trang thanh toán --}}
{{-- Cần biến: $vouchers (danh sách mã còn lượt), $summary (tóm tắt giỏ hàng) --}}
<div class="cart-box-section mb-3">
    <h6 class="fw-bold mb-3"><i class="bi bi-ticket-perforated me-1"></i> Mã giảm giá</h6>

    <div class="input-group mb-2">
        <input type="text" id="voucherInput" class="form-control text-uppercase"
            placeholder="Nhập mã giảm giá" value="{{ $summary['voucher_code'] }}">
        <button type="button" id="btnApplyVoucher" class="btn btn-cart">Áp dụng</button>
    </div>

    <div id="voucherMsg" class="small mb-2"></div>

    <div class="small text-muted mb-2">Hoặc chọn một mã bên dưới:</div>
    <div class="voucher-list">
        @foreach($vouchers as $v)
            <div class="voucher-item {{ $summary['voucher_code'] == $v->code ? 'active' : '' }}"
                data-code="{{ $v->code }}">
                <div>
                    <div class="voucher-code">{{ $v->code }}</div>
                    <small class="text-muted">Còn {{ $v->quantity }} lượt</small>
                </div>
                <div class="voucher-percent">Giảm {{ $v->discount_percent }}%</div>
            </div>
        @endforeach
    </div>

    <button type="button" id="btnClearVoucher" class="btn btn-link btn-sm text-danger p-0 mt-1"
        style="{{ $summary['voucher_code'] ? '' : 'display:none;' }}">
        Bỏ mã giảm giá
    </button>
</div>
