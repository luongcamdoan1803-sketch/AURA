@extends('shop.master')
@section('title', 'Hoa Chúc Mừng - AURA FLORIST')

@section('content')
<!-- ================= HERO BANNER HOA CHÚC MỪNG ================= -->
<div class="container-fluid px-0 mb-4">
    <div class="aura-hero-banner position-relative overflow-hidden d-flex align-items-center justify-content-center text-center">
        <!-- Ảnh nền Pinterest chất lượng cao kèm cơ chế chống chặn tải ảnh -->
        <img src="https://i.pinimg.com/1200x/4d/98/a7/4d98a790fc144cae02fcafedc46588de.jpg" 
             referrerpolicy="no-referrer"
             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1563245372-f21724e3856d?auto=format&fit=crop&w=2000&q=90';" 
             class="position-absolute top-0 start-0 w-100 h-100 aura-hero-img" alt="Hoa Chúc Mừng Aura Florist">
        
        <!-- Lớp phủ làm dịu nền để nổi bật tiêu đề -->
        <div class="aura-hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Khối nội dung chính giữa -->
        <div class="container position-relative z-2 text-white px-3 py-5">
            <div class="aura-sub-badge mb-3">
                <span class="aura-line"></span>
                <span class="aura-sub-text">GỬI TRAO THÀNH Ý</span>
                <span class="aura-line"></span>
            </div>

            <h1 class="aura-main-title mb-2">HOA CHÚC MỪNG</h1>
            
            <p class="aura-slogan mb-3">Vạn Sự Khởi Sắc &bull; Vững Bước Thành Công</p>
            
            <p class="aura-desc mx-auto mb-4 d-none d-md-block">
                Những thiết kế hoa rực rỡ, trang trọng thay ngàn lời chúc hồng phát, may mắn và thịnh vượng bền lâu đến đối tác, người thân và bạn bè.
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
            <li class="breadcrumb-item active fw-bold" style="color: #8C6239;">Hoa chúc mừng</li>
        </ol>
    </nav>

    <!-- Thanh bộ lọc sản phẩm -->
    <div class="card p-3 mb-5 border-0 shadow-sm rounded-4" style="background: #FFFDF9;">
        <form action="{{ url()->current() }}" method="GET" class="row g-3">
            <!-- Tìm theo tên -->
            <div class="col-md-3">
                <input type="text" name="keyword" class="form-control" placeholder="Tìm tên hoa chúc mừng..." value="{{ request('keyword') }}">
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
                    
                    <!-- NHÃN CHỮ KHUYẾN MÃI Ở GÓC TRÊN BÊN PHẢI ẢNH -->
                    @if($hasDiscount)
                        <div class="position-absolute top-0 end-0 m-2 z-2">
                            <span class="badge rounded-pill shadow-sm px-2 py-1 text-white fw-bold promo-badge">
                                <i class="fa-solid fa-bolt me-1"></i>Khuyến mãi
                            </span>
                        </div>
                    @endif

                    <!-- Nhấp vào ảnh mở Modal chi tiết master -->
                    <div class="img-box cursor-pointer btn-quick-view" data-id="{{ $product->id }}">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}">
                    </div>

                    <div class="card-body">
                        <div>
                            <h5 class="flower-title cursor-pointer btn-quick-view" data-id="{{ $product->id }}" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            <div class="star-box">
                                <i class="fa-solid fa-star text-warning"></i> {{ number_format($product->rating, 1) }}
                                <span class="text-muted small">({{ \App\Models\Review::count() }} đánh giá)</span>
                            </div>

                            <!-- KHU VỰC HIỂN THỊ GIÁ -->
                            <div class="flower-price-container mt-1">
                                @if($hasDiscount)
                                    <!-- Dòng trên: Giá mới màu đỏ nổi bật -->
                                    <div class="flower-price text-danger fw-bold lh-1 mb-1">
                                        {{ number_format($finalPrice, 0, ',', '.') }}đ
                                    </div>
                                    <!-- Dòng dưới: Giá cũ gạch ngang và % giảm -->
                                    <div class="d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                        <span class="text-decoration-line-through text-muted">
                                            {{ number_format($product->price, 0, ',', '.') }}đ
                                        </span>
                                        <span class="text-danger fw-semibold">
                                            -{{ $product->discount_percent }}%
                                        </span>
                                    </div>
                                @else
                                    <!-- Sản phẩm không có khuyến mãi -->
                                    <div class="flower-price">
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- NÚT XEM CHI TIẾT (kết nối trực tiếp với modal master) -->
                        <button type="button" class="btn btn-detail mt-2 btn-quick-view text-nowrap" data-id="{{ $product->id }}">
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

    <!-- Phân trang (Ẩn hoàn toàn dòng chữ Showing ... results) -->
    <div class="d-flex justify-content-center mt-4 clean-pagination">
        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
/* ================= HERO BANNER ================= */
.aura-hero-banner {
    min-height: 500px;
    background-color: #2b1f14;
}
.aura-hero-img {
    object-fit: cover;
    object-position: center 40%;
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