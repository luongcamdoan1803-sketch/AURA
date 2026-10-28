@extends('shop.master')
@section('title', 'Hoa Sinh Nhật - AURA FLORIST')

@section('content')
<!-- ================= HERO BANNER HOA SINH NHẬT ================= -->
<div class="container-fluid px-0 mb-4">
    <div class="aura-hero-banner position-relative overflow-hidden d-flex align-items-center justify-content-center text-center">
        <!-- Ảnh nền hoa sinh nhật rạng rỡ, nhiều bông lớn nở bung tươi tắn -->
        <img src="https://i.pinimg.com/1200x/ac/c6/f1/acc6f17017cc0568cd66be1059b0b590.jpg" 
             referrerpolicy="no-referrer"
             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1526047932273-341f2a7631f9?auto=format&fit=crop&w=2000&q=90';" 
             class="position-absolute top-0 start-0 w-100 h-100 aura-hero-img" alt="Hoa Sinh Nhật Aura Florist">
        
        <!-- Lớp phủ làm dịu nền giúp nổi bật chữ trắng -->
        <div class="aura-hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Khối nội dung chính giữa banner -->
        <div class="container position-relative z-2 text-white px-3 py-5">
            <div class="aura-sub-badge mb-3">
                <span class="aura-line"></span>
                <span class="aura-sub-text">MÓN QUÀ NGỌT NGÀO</span>
                <span class="aura-line"></span>
            </div>

            <h1 class="aura-main-title mb-2">HOA SINH NHẬT</h1>
            
            <p class="aura-slogan mb-3">Rạng Rỡ Tuổi Mới &bull; Trọn Vẹn Yêu Thương</p>
            
            <p class="aura-desc mx-auto mb-4 d-none d-md-block">
                Giai điệu sắc màu tươi vui và ấm áp, thay lời chúc tuổi mới luôn ngập tràn năng lượng tích cực, may mắn và hạnh phúc ngập tràn.
            </p>

            <a href="#flowerListArea" class="btn aura-btn-explore rounded-pill px-4 py-2 text-uppercase fw-semibold shadow-sm">
                Khám phá bộ sưu tập &rarr;
            </a>
        </div>
    </div>
</div>

<div class="container py-3" id="flowerListArea">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.all') }}" class="text-decoration-none text-muted">Sản phẩm</a></li>
            <li class="breadcrumb-item active fw-bold" style="color: #8C6239;">Hoa sinh nhật</li>
        </ol>
    </nav>

    <!-- Thanh bộ lọc sản phẩm -->
    <div class="card p-3 mb-5 border-0 shadow-sm rounded-4" style="background: #FFFDF9;">
        <form action="{{ url()->current() }}" method="GET" class="row g-3">
            <!-- Tìm theo tên -->
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm tên hoa..." value="{{ request('keyword') }}">
            </div>

            <!-- Lọc theo kiểu dáng (Bó / Hộp / Giỏ) -->
            <div class="col-md-2">
                <select name="style" class="form-select">
                    <option value="">-- Kiểu dáng --</option>
                    <option value="Bó" {{ request('style') == 'Bó' ? 'selected' : '' }}>Bó hoa</option>
                    <option value="Hộp" {{ request('style') == 'Hộp' ? 'selected' : '' }}>Hộp hoa</option>
                    <option value="Giỏ" {{ request('style') == 'Giỏ' ? 'selected' : '' }}>Giỏ hoa</option>
                </select>
            </div>

            <!-- Lọc theo mức giá -->
            <div class="col-md-3">
                <select name="price_range" class="form-select">
                    <option value="">-- Mức giá --</option>
                    <option value="under_500" {{ request('price_range') == 'under_500' ? 'selected' : '' }}>Dưới 500k</option>
                    <option value="500_1000" {{ request('price_range') == '500_1000' ? 'selected' : '' }}>500k - 1 triệu</option>
                    <option value="over_1000" {{ request('price_range') == 'over_1000' ? 'selected' : '' }}>Trên 1 triệu</option>
                </select>
            </div>

            <!-- Lọc theo đánh giá -->
            <div class="col-md-2">
                <select name="rating" class="form-select">
                    <option value="">-- Đánh giá --</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐ 5.0</option>
                    <option value="4.8" {{ request('rating') == '4.8' ? 'selected' : '' }}>⭐ từ 4.8</option>
                </select>
            </div>

            <!-- Nút lọc -->
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn btn-buy-now">
                    <i class="fa fa-filter me-1"></i> Lọc hoa
                </button>
            </div>
        </form>
    </div>

    <!-- Lưới 4 hoa 1 hàng -->
    <div class="row g-3 g-lg-4">
        @forelse($products as $product)
            @php
                $hasDiscount = isset($product->discount_percent) && $product->discount_percent > 0;
                $finalPrice = $hasDiscount 
                    ? $product->price * (1 - ($product->discount_percent / 100)) 
                    : $product->price;
            @endphp

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="flower-card shadow-sm position-relative">
                    
                    <!-- NHÃN CHỮ KHUYẾN MÃI Ở GÓC TRÊN BÊN PHẢI ẢNH THẺ NGOÀI -->
                    @if($hasDiscount)
                        <div class="position-absolute top-0 end-0 m-2 z-2">
                            <span class="badge rounded-pill shadow-sm px-2 py-1 text-white fw-bold promo-badge">
                                <i class="fa-solid fa-bolt me-1"></i>Khuyến mãi
                            </span>
                        </div>
                    @endif

                    <div class="img-box cursor-pointer" onclick="openProductQuickView({{ $product->id }})">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}">
                    </div>

                    <div class="card-body">
                        <div>
                            <h5 class="flower-title cursor-pointer" onclick="openProductQuickView({{ $product->id }})" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            <div class="star-box">
                                <i class="fa-solid fa-star text-warning"></i> {{ number_format($product->rating, 1) }}
                                <span class="text-muted small">({{ \App\Models\Review::count() }} đánh giá)</span>
                            </div>

                            <!-- KHU VỰC HIỂN THỊ GIÁ THẺ NGOÀI (GIÁ MỚI TRÊN, GIÁ CŨ DƯỚI) -->
                            <div class="flower-price-container mt-1">
                                @if($hasDiscount)
                                    <div class="flower-price text-danger fw-bold lh-1 mb-1">
                                        {{ number_format($finalPrice, 0, ',', '.') }}đ
                                    </div>
                                    <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <span class="text-decoration-line-through text-muted">
                                            {{ number_format($product->price, 0, ',', '.') }}đ
                                        </span>
                                        <span class="text-danger fw-semibold">
                                            -{{ $product->discount_percent }}%
                                        </span>
                                    </div>
                                @else
                                    <div class="flower-price">
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- NÚT XEM CHI TIẾT -->
                        <button type="button" class="btn btn-detail mt-2 btn-quick-view text-nowrap" onclick="openProductQuickView({{ $product->id }})">
                            <i class="fa-regular fa-eye me-1"></i> Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted fs-5">Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p>
            </div>
        @endforelse
    </div>

    <!-- Phân trang giữ lại các tham số lọc (Ẩn hoàn toàn chữ Showing ... results) -->
    <div class="d-flex justify-content-center mt-4 clean-pagination">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- ================= MODAL XEM CHI TIẾT ĐÃ CĂN ĐỀU VÀ BỎ CUỘN ================= -->
<div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4 border-0 shadow position-relative" style="background: #ffffff;">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body p-4">
                <div class="row g-4 align-items-start">
                    <!-- Ảnh hoa modal bên trái: Cố định kích thước chuẩn 420px -->
                    <div class="col-md-6 position-relative">
                        <div id="modalDiscountBadge" class="position-absolute top-0 end-0 m-3 z-3 d-none">
                            <span class="badge rounded-pill shadow px-3 py-2 text-white fw-bold promo-badge">
                                <i class="fa-solid fa-bolt me-1"></i>Khuyến mãi
                            </span>
                        </div>
                        <div class="shadow-sm" style="width: 100%; height: 420px; border-radius: 20px; overflow: hidden; background: #F8F9FA;">
                            <img id="modalImg" src="" alt="Hoa tươi" style="width: 100% !important; height: 100% !important; object-fit: cover !important; object-position: center !important; display: block !important;">
                        </div>
                    </div>

                    <!-- Thông tin hoa modal bên phải -->
                    <div class="col-md-6 ps-md-4">
                        <span id="modalCategory" class="badge px-3 py-2 rounded-pill mb-2" style="background-color: #F5EBE1; color: #8C6239;"></span>
                        
                        <h3 id="modalName" class="fw-bold text-dark mb-2"></h3>

                        <!-- Đánh giá sao -->
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-warning me-2"><i class="fa-solid fa-star"></i></span>
                            <span id="modalRating" class="fw-bold text-dark me-2"></span>
                            <span id="modalReviewsCount" class="text-muted small"></span>
                        </div>

                        <!-- KHU VỰC GIÁ BÊN TRONG MODAL -->
                        <div class="mb-3">
                            <div id="modalFinalPrice" class="fs-2 fw-bold text-danger lh-1 mb-1"></div>
                            
                            <div id="modalDiscountRow" class="d-flex align-items-center gap-2 d-none">
                                <span id="modalOriginalPrice" class="text-decoration-line-through text-muted fs-5"></span>
                                <span id="modalPercent" class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold px-2 py-1"></span>
                            </div>
                        </div>

                        <!-- Mô tả hoa: Không giới hạn chiều cao để bung hết nội dung -->
                        <div id="modalDesc" class="text-secondary small mb-3" style="line-height: 1.6;"></div>

                        <!-- Chọn số lượng -->
                        <div class="d-flex align-items-center mb-3">
                            <span class="fw-semibold me-3 small">Số lượng:</span>
                            <div class="input-group" style="width: 120px;">
                                <button class="btn btn-outline-secondary btn-sm px-3" type="button" onclick="changeQty(-1)">-</button>
                                <input type="number" id="modalQty" class="form-control form-control-sm text-center" value="1" min="1">
                                <button class="btn btn-outline-secondary btn-sm px-3" type="button" onclick="changeQty(1)">+</button>
                            </div>
                        </div>

                        <!-- Nút Thêm giỏ hàng & Mua ngay -->
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn w-50 py-2 rounded-3 fw-semibold" style="background: #F3EAE2; color: #8C6239; border: 1px solid #E2D3C4;">
                                <i class="fa-solid fa-cart-shopping me-1"></i> Thêm giỏ hàng
                            </button>
                            <button type="button" class="btn w-50 py-2 rounded-3 text-white fw-semibold" style="background: #8C6239;">
                                <i class="fa-solid fa-bolt me-1"></i> Mua ngay
                            </button>
                        </div>

                        <div class="text-center pt-1">
                            <a id="modalDetailLink" href="#" class="text-decoration-none small text-muted">
                                Xem đầy đủ đánh giá & bình luận &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openProductQuickView(productId) {
    fetch('/product-json/' + productId)
        .then(res => res.json())
        .then(data => {
            document.getElementById('modalImg').src = data.image;
            document.getElementById('modalCategory').innerText = data.category;
            document.getElementById('modalName').innerText = data.name;
            document.getElementById('modalRating').innerText = data.rating + ' / 5.0';
            document.getElementById('modalReviewsCount').innerText = '(' + (data.reviews_count || 0) + ' đánh giá)';
            document.getElementById('modalDesc').innerHTML = data.description || '';
            document.getElementById('modalQty').value = 1;
            document.getElementById('modalDetailLink').href = '/san-pham/' + data.id;

            const modalDiscountBadge = document.getElementById('modalDiscountBadge');
            const modalFinalPrice = document.getElementById('modalFinalPrice');
            const modalDiscountRow = document.getElementById('modalDiscountRow');
            const modalOriginalPrice = document.getElementById('modalOriginalPrice');
            const modalPercent = document.getElementById('modalPercent');

            let finalPrice = data.final_price || data.price;
            modalFinalPrice.innerText = finalPrice;

            let discount = parseInt(data.discount_percent) || 0;
            if (discount > 0) {
                modalDiscountBadge.classList.remove('d-none');
                modalOriginalPrice.innerText = data.original_price || data.price;
                modalPercent.innerText = '-' + discount + '%';
                modalDiscountRow.classList.remove('d-none');
            } else {
                modalDiscountBadge.classList.add('d-none');
                modalDiscountRow.classList.add('d-none');
            }

            var myModal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            myModal.show();
        })
        .catch(err => {
            window.location.href = '/san-pham/' + productId;
        });
}

function changeQty(delta) {
    let input = document.getElementById('modalQty');
    let val = parseInt(input.value) + delta;
    if (val >= 1) input.value = val;
}
</script>

<style>
/* ================= HERO BANNER HOA SINH NHẬT ================= */
.aura-hero-banner {
    min-height: 500px;
    background-color: #2b1f14;
}
.aura-hero-img {
    object-fit: cover;
    object-position: center 35%;
    filter: brightness(0.82) contrast(1.05);
}
.aura-hero-overlay {
    background: radial-gradient(circle at center, rgba(35, 22, 14, 0.35) 0%, rgba(20, 10, 5, 0.65) 100%);
    z-index: 1;
}
.aura-sub-badge {
    display: inline-flex;
    align-items: center;
    gap: 14px;
}
.aura-line {
    display: inline-block;
    width: 40px;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.8);
}
.aura-sub-text {
    font-size: 0.85rem;
    letter-spacing: 4px;
    font-weight: 600;
    color: #f8f9fa;
}
.aura-main-title {
    font-size: 3.5rem;
    font-weight: 800;
    letter-spacing: 6px;
    text-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);
}
.aura-slogan {
    font-size: 1.45rem;
    font-style: italic;
    font-weight: 400;
    color: #fdfaf6;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
}
.aura-desc {
    max-width: 650px;
    font-size: 0.98rem;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.92);
    text-shadow: 0 1px 6px rgba(0, 0, 0, 0.5);
}
.aura-btn-explore {
    background-color: #f3eae2;
    color: #5c3d23;
    border: none;
    font-size: 0.88rem;
    letter-spacing: 1.5px;
    transition: all 0.3s ease;
}
.aura-btn-explore:hover {
    background-color: #8c6239;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
}
@media (max-width: 768px) {
    .aura-hero-banner {
        min-height: 360px;
    }
    .aura-main-title {
        font-size: 2.2rem;
        letter-spacing: 4px;
    }
    .aura-slogan {
        font-size: 1.15rem;
    }
}

.cursor-pointer {
    cursor: pointer;
}
.promo-badge {
    background: linear-gradient(135deg, #e63946, #c1121f);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 3px 8px rgba(230, 57, 70, 0.4);
}
#modalDesc p {
    margin-bottom: 0.4rem;
}
#modalDesc p:last-child {
    margin-bottom: 0;
}

/* ẨN TOÀN BỘ DÒNG CHỮ "Showing ... to ... of ... results" */
.clean-pagination nav > div:first-child,
.clean-pagination .small.text-muted,
.clean-pagination p.text-sm,
.clean-pagination p.small {
    display: none !important;
}
.clean-pagination .pagination {
    margin-bottom: 0 !important;
}
.clean-pagination .page-item.active .page-link {
    background-color: #8C6239 !important;
    border-color: #8C6239 !important;
    color: #ffffff !important;
}
.clean-pagination .page-link {
    color: #8C6239;
}
</style>
@endsection