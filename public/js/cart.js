/* =====================================================
   AURA FLORIST - CART.JS (jQuery + AJAX)
   Thêm giỏ hàng, tăng/giảm số lượng, xóa, áp mã giảm giá
   Cần: jQuery, Bootstrap JS, biến window.AURA_ROUTES (khai báo ở header)
   ===================================================== */

window.AuraCart = (function ($) {

    var R = window.AURA_ROUTES || {};
    var MAX_QTY = 99;

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* ---------- Thông báo nhỏ (toast) ---------- */
    function toast(message, type) {
        var host = $('#auraToastHost');

        if (!host.length) {
            host = $('<div id="auraToastHost" class="aura-toast-host"></div>').appendTo('body');
        }

        var bg = type === 'error' ? 'text-bg-danger' : 'text-bg-success';
        var icon = type === 'error' ? 'fa-circle-exclamation' : 'fa-circle-check';

        var el = $(
            '<div class="toast align-items-center ' + bg + ' border-0 mb-2" role="alert">' +
            '<div class="d-flex"><div class="toast-body"><i class="fa-solid ' + icon + ' me-2"></i></div>' +
            '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>'
        );

        el.find('.toast-body').append(document.createTextNode(message));
        host.append(el);

        var t = new bootstrap.Toast(el[0], { delay: 2800 });
        el.on('hidden.bs.toast', function () { el.remove(); });
        t.show();
    }

    function errorMessage(xhr) {
        var j = xhr.responseJSON || {};

        if (j.errors) {
            return j.errors[Object.keys(j.errors)[0]][0];
        }

        return j.message || 'Có lỗi xảy ra, vui lòng thử lại.';
    }

    /* ---------- Số lượng trên icon giỏ hàng ---------- */
    function setCount(n) {
        $('.js-cart-count').text(n);
    }

    /* ---------- Thêm vào giỏ ---------- */
    function add(productId, qty) {
        return $.ajax({
            url: R.add, method: 'POST', dataType: 'json',
            data: { product_id: productId, qty: qty || 1 }
        }).done(function (res) {
            setCount(res.count);
            toast(res.message);
        }).fail(function (xhr) {
            toast(errorMessage(xhr), 'error');
        });
    }

    /* ---------- Vẽ lại giao diện theo dữ liệu server trả về ---------- */
    function render(root, res) {
        setCount(res.count);

        if (res.empty) {
            var go = root.data('empty-redirect');
            if (go) { window.location.href = go; return; }

            root.find('.js-filled').addClass('d-none');
            root.find('.js-empty').removeClass('d-none');
            return;
        }

        if (res.line) {
            var row = root.find('[data-line][data-id="' + res.line.id + '"]');
            row.find('.js-qty-input').val(res.line.qty);
            row.find('.js-line-total').text(res.line.line_total);
        }

        root.find('.js-subtotal').text(res.summary.subtotal);
        root.find('.js-discount').text(res.summary.discount);
        root.find('.js-shipping').text(res.summary.shipping);
        root.find('.js-total').text(res.summary.total);

        var v = res.voucher;
        root.find('.js-discount-row').toggleClass('d-none', !v);
        root.find('.js-voucher-applied').toggleClass('show', !!v);
        root.find('.js-voucher-applied-text').text(v ? v.code + ' (-' + v.percent + '%)' : '');

        root.find('.js-voucher-radio').each(function () {
            var on = v && $(this).val() === v.code;
            $(this).prop('checked', !!on);
            $(this).closest('.voucher-option').toggleClass('active', !!on);
        });

        if (!v) { root.find('.js-voucher-input').val(''); }
    }

    function voucherMsg(root, text, ok) {
        root.find('.js-voucher-msg').text(text || '').removeClass('ok err').addClass(text ? (ok ? 'ok' : 'err') : '');
    }

    /* ---------- Tăng / giảm / xóa trong giỏ & trang thanh toán ---------- */
    function changeQty(row, qty) {
        var root = row.closest('[data-cart-root]');

        qty = parseInt(qty, 10);
        if (isNaN(qty) || qty < 1) { qty = 1; }
        if (qty > MAX_QTY) { qty = MAX_QTY; toast('Số lượng tối đa là ' + MAX_QTY + '.', 'error'); }

        row.addClass('is-loading');

        $.ajax({
            url: R.update, method: 'POST', dataType: 'json',
            data: { product_id: row.data('id'), qty: qty, mode: root.data('mode') }
        }).done(function (res) {
            render(root, res);
        }).fail(function (xhr) {
            toast(errorMessage(xhr), 'error');
        }).always(function () {
            row.removeClass('is-loading');
        });
    }

    $(document).on('click', '.js-qty-minus', function () {
        var row = $(this).closest('[data-line]');
        var cur = parseInt(row.find('.js-qty-input').val(), 10) || 1;
        if (cur > 1) { changeQty(row, cur - 1); }
    });

    $(document).on('click', '.js-qty-plus', function () {
        var row = $(this).closest('[data-line]');
        changeQty(row, (parseInt(row.find('.js-qty-input').val(), 10) || 1) + 1);
    });

    $(document).on('change', '.js-qty-input', function () {
        var row = $(this).closest('[data-line]');
        if (row.length) { changeQty(row, $(this).val()); }
    });

    $(document).on('click', '.js-remove', function () {
        var row = $(this).closest('[data-line]');
        var root = row.closest('[data-cart-root]');

        row.addClass('is-loading');

        $.ajax({
            url: R.remove, method: 'POST', dataType: 'json',
            data: { product_id: row.data('id'), mode: root.data('mode') }
        }).done(function (res) {
            row.fadeOut(180, function () { row.remove(); });
            render(root, res);
        }).fail(function (xhr) {
            row.removeClass('is-loading');
            toast(errorMessage(xhr), 'error');
        });
    });

    /* ---------- Mã giảm giá ---------- */
    function applyVoucher(root, code) {
        code = $.trim(code || '');

        if (!code) {
            voucherMsg(root, 'Vui lòng nhập mã giảm giá.', false);
            return;
        }

        $.ajax({
            url: R.voucher, method: 'POST', dataType: 'json',
            data: { code: code, mode: root.data('mode') }
        }).done(function (res) {
            render(root, res);
            voucherMsg(root, res.message, true);
        }).fail(function (xhr) {
            var res = xhr.responseJSON;
            if (res && res.summary) { render(root, res); }
            voucherMsg(root, errorMessage(xhr), false);
            root.find('.js-voucher-radio').prop('checked', false).closest('.voucher-option').removeClass('active');
        });
    }

    $(document).on('click', '.js-apply-voucher', function () {
        var root = $(this).closest('[data-cart-root]');
        applyVoucher(root, root.find('.js-voucher-input').val());
    });

    $(document).on('keydown', '.js-voucher-input', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            var root = $(this).closest('[data-cart-root]');
            applyVoucher(root, $(this).val());
        }
    });

    $(document).on('change', '.js-voucher-radio', function () {
        var root = $(this).closest('[data-cart-root]');
        root.find('.js-voucher-input').val($(this).val());
        applyVoucher(root, $(this).val());
    });

    $(document).on('click', '.js-remove-voucher', function () {
        var root = $(this).closest('[data-cart-root]');

        $.ajax({
            url: R.voucher, method: 'POST', dataType: 'json',
            data: { _method: 'DELETE', mode: root.data('mode') }
        }).done(function (res) {
            render(root, res);
            voucherMsg(root, res.message, true);
        });
    });

    /* ---------- Nút ở trang chi tiết sản phẩm ---------- */
    function qtyFor(btn) {
        var input = btn.closest('[data-product-actions]').find('.js-detail-qty');
        var q = parseInt(input.val(), 10);
        return isNaN(q) || q < 1 ? 1 : Math.min(q, MAX_QTY);
    }

    $(document).on('click', '.js-add-to-cart', function () {
        var btn = $(this);
        btn.prop('disabled', true);
        add(btn.data('product-id'), qtyFor(btn)).always(function () { btn.prop('disabled', false); });
    });

    $(document).on('click', '.js-buy-now', function () {
        var btn = $(this);
        window.location.href = R.checkout + '?product_id=' + btn.data('product-id') + '&qty=' + qtyFor(btn);
    });

    $(document).on('click', '.js-detail-minus, .js-detail-plus', function () {
        var input = $(this).closest('[data-product-actions]').find('.js-detail-qty');
        var q = (parseInt(input.val(), 10) || 1) + ($(this).hasClass('js-detail-plus') ? 1 : -1);
        input.val(Math.max(1, Math.min(MAX_QTY, q)));
    });

    /* ---------- Chọn phương thức thanh toán ---------- */
    $(document).on('change', '.js-pay-radio', function () {
        $('.pay-option').removeClass('active');
        $(this).closest('.pay-option').addClass('active');
    });

    /* ---------- Form thanh toán: kiểm tra phía client + chống bấm 2 lần ---------- */
    $(document).on('submit', '#checkoutForm', function (e) {
        var form = this;

        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            $(form).addClass('was-validated');
            var firstBad = $(form).find(':invalid').first();
            if (firstBad.length) { firstBad[0].focus(); }
            return;
        }

        $(form).find('.js-place-order').prop('disabled', true).text('Đang xử lý...');
    });

    /* ---------- Sao chép nội dung chuyển khoản ---------- */
    $(document).on('click', '.js-copy', function () {
        var text = String($(this).data('copy'));
        var btn = $(this);

        function done() {
            var old = btn.html();
            btn.html('<i class="bi bi-check2 me-1"></i>Đã sao chép');
            setTimeout(function () { btn.html(old); }, 1600);
        }

        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(done);
        } else {
            var ta = $('<textarea>').val(text).appendTo('body').select();
            document.execCommand('copy');
            ta.remove();
            done();
        }
    });

    return { add: add, toast: toast };

})(jQuery);
