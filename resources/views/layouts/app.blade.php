<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'AURA FLORIST - Cửa Hàng Hoa Tươi Nghệ Thuật')
    </title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <!-- CSS chính -->
    <link
        rel="stylesheet"
        href="{{ asset('css/home.css') }}"
    >

    <!-- CSS Shop -->
    <link
        rel="stylesheet"
        href="{{ asset('css/shop.css') }}"
    >

    <!-- CSS Giỏ hàng & Thanh toán -->
    <link
        rel="stylesheet"
        href="{{ asset('css/cart.css') }}"
    >

    <!-- CSS Chatbot -->
    <link
        rel="stylesheet"
        href="{{ asset('css/chatbot.css') }}"
    >

    <!-- CSS riêng của từng trang -->
    @stack('styles')
</head>

<body>

    <!-- HEADER -->
    @include('layouts.header')


    <!-- NỘI DUNG -->
    <main class="py-4">
        @yield('content')
    </main>


    <!-- FOOTER -->
    @include('layouts.footer')


    <!-- POPUP XEM CHI TIẾT SẢN PHẨM -->
    <div
        class="modal fade"
        id="modalQuickView"
        tabindex="-1"
        aria-labelledby="modalQuickViewLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content modal-flower-content">

                <div class="modal-header border-0">

                    <button
                        type="button"
                        class="btn-close ms-auto"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <div class="modal-body p-0">

                    <div class="row g-0">

                        <!-- HÌNH ẢNH -->
                        <div class="col-lg-6">

                            <div class="modal-img-container">

                                <img
                                    id="modalFlowerImg"
                                    src=""
                                    alt="Sản phẩm"
                                >

                            </div>

                        </div>


                        <!-- THÔNG TIN -->
                        <div class="col-lg-6">

                            <div class="p-4 p-lg-5">

                                <!-- Danh mục -->
                                <span
                                    id="modalFlowerCategory"
                                    class="badge px-3 py-2 rounded-pill mb-3"
                                    style="background-color: #F5EBE1; color: #8C6239;"
                                >
                                    Hoa tươi
                                </span>


                                <!-- Tên sản phẩm -->
                                <h2
                                    id="modalFlowerName"
                                    class="fw-bold text-dark mb-3"
                                >
                                </h2>


                                <!-- Đánh giá -->
                                <div
                                    id="modalFlowerRating"
                                    class="mb-3"
                                >
                                </div>


                                <!-- Giá -->
                                <div
                                    id="modalFlowerPrice"
                                    class="fs-3 fw-bold text-danger mb-4"
                                >
                                </div>


                                <!-- Mô tả -->
                                <div
                                    id="modalFlowerDesc"
                                    class="text-secondary mb-4"
                                >
                                </div>


                                <!-- Số lượng -->
                                <div class="d-flex align-items-center gap-2 mb-4">

                                    <span class="fw-semibold">
                                        Số lượng:
                                    </span>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="changeQty(-1)"
                                    >
                                        -
                                    </button>

                                    <input
                                        type="number"
                                        id="modalFlowerQty"
                                        value="1"
                                        min="1"
                                        class="form-control text-center"
                                        style="width: 70px;"
                                    >

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="changeQty(1)"
                                    >
                                        +
                                    </button>

                                </div>


                                <!-- NÚT -->
                                <div class="d-flex gap-3">

                                    <button
                                        type="button"
                                        class="btn btn-add-cart flex-fill py-3"
                                        id="btnAddToCart"
                                    >
                                        <i class="fa-solid fa-cart-plus me-2"></i>
                                        Thêm giỏ hàng
                                    </button>


                                    <button
                                        type="button"
                                        class="btn btn-buy-now flex-fill py-3"
                                        id="btnBuyNow"
                                    >
                                        <i class="fa-solid fa-bolt me-2"></i>
                                        Mua ngay
                                    </button>

                                </div>


                                <!-- Trang chi tiết -->
                                <div class="mt-4 text-center">

                                    <a
                                        href="#"
                                        id="modalDetailLink"
                                        class="text-decoration-none text-muted"
                                    >
                                        Xem đầy đủ đánh giá & bình luận →
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- THÔNG BÁO THÊM GIỎ HÀNG -->
    <div
        class="position-fixed bottom-0 end-0 p-3"
        style="z-index: 31000;"
    >

        <div
            id="cartToast"
            class="toast align-items-center text-bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >

            <div class="d-flex">

                <div class="toast-body">

                    <i class="fa-solid fa-circle-check me-2"></i>

                    Đã thêm vào giỏ hàng thành công!

                </div>

                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                ></button>

            </div>

        </div>

    </div>


    <!-- CHATBOT -->
    @include('layouts.chatbot')


    <!-- jQuery (dùng cho giỏ hàng AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>

    <!-- JS Giỏ hàng -->
    <script src="{{ asset('js/cart.js') }}"></script>


    <!-- Chatbot JS -->
    <script src="{{ asset('js/chatbot.js') }}"></script>


    <!-- XỬ LÝ POPUP SẢN PHẨM -->
    <script>

        let currentProduct = null;


        // Tăng giảm số lượng
        function changeQty(delta) {

            const qtyInput = document.getElementById('modalFlowerQty');

            let qty = parseInt(qtyInput.value) || 1;

            qty += delta;

            if (qty < 1) {
                qty = 1;
            }

            qtyInput.value = qty;
        }


        document.addEventListener('DOMContentLoaded', function () {

            // Bấm nút Xem chi tiết
            document.addEventListener('click', function (event) {

                const button = event.target.closest('.btn-quick-view');

                if (!button) {
                    return;
                }

                event.preventDefault();

                const productId = button.getAttribute('data-id');

                if (!productId) {
                    return;
                }


                // Gọi API đang sử dụng trong Shop
                fetch('/api/san-pham/' + productId)

                    .then(function (response) {

                        if (!response.ok) {
                            throw new Error('Không thể tải sản phẩm');
                        }

                        return response.json();
                    })

                    .then(function (res) {

                        currentProduct = res;


                        // Hình ảnh
                        document.getElementById('modalFlowerImg').src =
                            res.image;


                        // Tên sản phẩm
                        document.getElementById('modalFlowerName').textContent =
                            res.name;


                        // Danh mục
                        document.getElementById('modalFlowerCategory').textContent =
                            res.category || 'Hoa tươi';


                        // Giá
                        document.getElementById('modalFlowerPrice').textContent =
                            res.price;


                        // Mô tả
                        document.getElementById('modalFlowerDesc').innerHTML =
                            res.description || '';


                        // Đánh giá
                        document.getElementById('modalFlowerRating').innerHTML =
                            '<i class="fa-solid fa-star text-warning"></i> ' +
                            '<strong>' + res.rating + '</strong> / 5.0';


                        // Reset số lượng
                        document.getElementById('modalFlowerQty').value = 1;


                        // Link trang chi tiết
                        document.getElementById('modalDetailLink').href =
                            '/san-pham/' + res.id;


                        // Mở popup
                        const modalElement =
                            document.getElementById('modalQuickView');

                        const modal =
                            bootstrap.Modal.getOrCreateInstance(modalElement);

                        modal.show();

                    })

                    .catch(function (error) {

                        console.error(
                            'Lỗi tải thông tin sản phẩm:',
                            error
                        );

                        alert(
                            'Không thể tải thông tin sản phẩm.'
                        );

                    });

            });


            // Nút thêm vào giỏ (AJAX)
            $('#btnAddToCart').on('click', function () {

                if (!currentProduct) {
                    return;
                }

                const qty = parseInt($('#modalFlowerQty').val(), 10) || 1;

                AuraCart.add(currentProduct.id, qty).done(function () {

                    const modal = bootstrap.Modal.getInstance(
                        document.getElementById('modalQuickView')
                    );

                    if (modal) {
                        modal.hide();
                    }

                });

            });


            // Nút mua ngay
            const buyNowButton =
                document.getElementById('btnBuyNow');


            if (buyNowButton) {

                buyNowButton.addEventListener('click', function () {

                    if (!currentProduct) {
                        return;
                    }


                    const qty =
                        document.getElementById('modalFlowerQty').value;


                    window.location.href =
                        "{{ route('checkout') }}" +
                        "?product_id=" +
                        currentProduct.id +
                        "&qty=" +
                        qty;

                });

            }

        });

    </script>


    <!-- JS riêng từng trang -->
    @stack('scripts')

</body>

</html>