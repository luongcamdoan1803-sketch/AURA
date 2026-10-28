<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AURA FLORIST')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <style>
        /* Ghim nút dấu X lên góc trên bên phải của modal */
        .btn-close-corner {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1065;
            background-size: 14px;
            opacity: 0.65;
            transition: transform 0.2s ease, opacity 0.2s ease;
            cursor: pointer;
        }
        .btn-close-corner:hover {
            opacity: 1;
            transform: scale(1.15);
        }
        .promo-badge {
            background: linear-gradient(135deg, #e63946, #c1121f);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 3px 8px rgba(230, 57, 70, 0.4);
        }

        /* KHUNG ẢNH MODAL: ÉP CỐ ĐỊNH TỈ LỆ VUÔNG 1:1 TUYỆT ĐỐI */
        .modal-img-container {
            width: 100% !important;
            aspect-ratio: 1 / 1 !important;
            height: auto !important;
            max-height: 480px !important;
            overflow: hidden !important;
            border-radius: 20px !important;
            background-color: #f8f9fa !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* Ảnh luôn căng kín khung vuông 1:1, không méo, không chênh lệch */
        .modal-img-container #modalFlowerImg {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: center !important;
            display: block !important;
        }
    </style>
</head>
<body>

    <!-- KHU VỰC HIỂN THỊ HOA -->
    @include('layouts.header')
    @yield('content')
    @include('layouts.footer')

    <!-- POPUP MODAL XEM CHI TIẾT -->
    <div class="modal fade" id="modalQuickView" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content modal-flower-content position-relative p-4">
                
                <!-- NÚT DẤU X ĐẶT Ở GÓC TRÊN CÙNG BÊN PHẢI -->
                <button type="button" class="btn-close fs-5 btn-close-corner" onclick="closeFlowerModal()" aria-label="Close"></button>

                <div class="modal-body p-0 pt-2">
                    <div class="row g-4 align-items-start">
                        <!-- Cột Trái: Ảnh Hoa Lớn kèm Badge Khuyến Mãi -->
                        <div class="col-md-6 position-relative align-self-start">
                            <div id="modalFlowerDiscountBadge" class="position-absolute top-0 end-0 m-3 z-3 d-none">
                                <span class="badge rounded-pill shadow px-3 py-2 text-white fw-bold promo-badge">
                                    <i class="fa-solid fa-bolt me-1"></i>Khuyến mãi
                                </span>
                            </div>
                            <div class="modal-img-container shadow-sm">
                                <img id="modalFlowerImg" src="" alt="Hoa tươi">
                            </div>
                        </div>

                        <!-- Cột Phải: Thông tin chi tiết -->
                        <div class="col-md-6 ps-md-4">
                            <span class="badge bg-light text-dark mb-3 border px-3 py-2 fs-6" id="modalFlowerCategory">Hoa</span>
                            <h2 class="fw-bold mb-3" id="modalFlowerName" style="color: #333;">Tên hoa</h2>
                            <div class="star-box mb-3 fs-5" id="modalFlowerRating"></div>

                            <!-- KHU VỰC HIỂN THỊ GIÁ TRONG MODAL -->
                            <div class="mb-3">
                                <!-- Giá mới màu đỏ nổi bật -->
                                <div class="text-danger fw-bold fs-2 lh-1 mb-2" id="modalFlowerPrice">0đ</div>
                                
                                <!-- Dòng dưới: Giá cũ gạch ngang và nhãn giảm giá -->
                                <div id="modalFlowerDiscountRow" class="d-flex align-items-center gap-2 d-none">
                                    <span class="text-decoration-line-through text-muted fs-5" id="modalFlowerOriginalPrice"></span>
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold px-2 py-1" id="modalFlowerPercent"></span>
                                </div>
                            </div>

<div class="text-muted small mb-4" id="modalFlowerDesc" style="line-height: 1.6;">Mô tả tóm tắt...</div>
                            <div class="d-flex align-items-center mb-4">
                                <label class="fw-semibold me-3 fs-5">Số lượng:</label>
                                <div class="input-group" style="width: 140px;">
                                    <button class="btn btn-outline-secondary px-3" type="button" onclick="changeQty(-1)">-</button>
                                    <input type="number" id="modalFlowerQty" class="form-control text-center fs-5" value="1" min="1">
                                    <button class="btn btn-outline-secondary px-3" type="button" onclick="changeQty(1)">+</button>
                                </div>
                            </div>

                            <div class="d-flex gap-3 pt-2">
                                <button class="btn btn-add-cart flex-fill py-3 fs-5" id="btnAddToCart">
                                    <i class="fa fa-cart-plus me-2"></i> Thêm giỏ hàng
                                </button>
                                <button class="btn btn-buy-now flex-fill py-3 fs-5" id="btnBuyNow">
                                    <i class="fa fa-bolt me-2"></i> Mua ngay
                                </button>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <a href="#" id="modalDetailLink" class="text-decoration-none text-muted">
                                    Xem đầy đủ đánh giá & bình luận &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Toast thông báo thêm giỏ hàng -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1090">
        <div id="cartToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fa-solid fa-circle-check me-2"></i> Đã thêm vào giỏ hàng thành công!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script>
        let currentProduct = null;

        function changeQty(delta) {
            let qty = parseInt($('#modalFlowerQty').val()) || 1;
            qty += delta;
            if (qty < 1) qty = 1;
            $('#modalFlowerQty').val(qty);
        }

        $(document).ready(function() {
            // Xem chi tiết hoa trên Modal
            $(document).on('click', '.btn-quick-view', function() {
                let productId = $(this).data('id');
                
                // Gọi API lấy dữ liệu chi tiết hoa
                $.ajax({
                    url: '/product-json/' + productId,
                    type: 'GET',
                    error: function() {
                        return $.ajax({ url: '/api/san-pham/' + productId, type: 'GET' });
                    },
                    success: function(res) {
                        currentProduct = res;
                        $('#modalFlowerImg').attr('src', res.image);
                        $('#modalFlowerName').text(res.name);
                        $('#modalFlowerCategory').text(res.category || 'Hoa tươi');
                        $('#modalFlowerDesc').html(res.description || '');
                        $('#modalFlowerRating').html(`<i class="fa-solid fa-star text-warning"></i> <strong>${res.rating}</strong> / 5.0 (${res.reviews_count || 0} đánh giá)`);
                        $('#modalFlowerQty').val(1);
                        $('#modalDetailLink').attr('href', '/san-pham/' + res.id);

                        // Xử lý giá mới, giá cũ và phần trăm giảm
                        let discount = parseInt(res.discount_percent) || 0;
                        let finalPrice = res.final_price || res.price;
                        let origPrice = res.original_price || res.price;

                        $('#modalFlowerPrice').text(finalPrice);

                        if (discount > 0) {
                            $('#modalFlowerDiscountBadge').removeClass('d-none');
                            $('#modalFlowerOriginalPrice').text(origPrice);
                            $('#modalFlowerPercent').text('Giảm ' + discount + '%');
                            $('#modalFlowerDiscountRow').removeClass('d-none');
                        } else {
                            $('#modalFlowerDiscountBadge').addClass('d-none');
                            $('#modalFlowerDiscountRow').addClass('d-none');
                        }

                        let modal = new bootstrap.Modal(document.getElementById('modalQuickView'));
                        modal.show();
                    }
                });
            });

            // Nút Thêm giỏ hàng
            $('#btnAddToCart').on('click', function() {
                if (!currentProduct) return;
                let qty = parseInt($('#modalFlowerQty').val(), 10) || 1;
                AuraCart.add(currentProduct.id, qty).done(function() {
                    closeFlowerModal();
                });
            });

            // Nút Mua ngay
            $('#btnBuyNow').on('click', function() {
                if (currentProduct) {
                    let qty = $('#modalFlowerQty').val();
                    window.location.href = "{{ route('checkout') }}?product_id=" + currentProduct.id + "&qty=" + qty;
                }
            });
        });

        // Hàm đóng modal
        function closeFlowerModal() {
            const modalEl = document.getElementById('modalQuickView');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
            $('#modalQuickView').removeClass('show').css('display', 'none');
            $('.modal-backdrop').remove();$('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        }
    </script>
</body>
</html>