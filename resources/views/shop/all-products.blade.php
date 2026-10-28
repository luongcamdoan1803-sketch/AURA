@extends('shop.master')
@section('title', 'Tất Cả Sản Phẩm - AURA FLORIST')

@section('content')
<!-- ================= HERO BANNER LỚN CHUẨN PHONG CÁCH AURA FLORIST ================= -->
<div class="container-fluid px-0 mb-4">
    <div class="aura-hero-banner position-relative overflow-hidden d-flex align-items-center justify-content-center text-center">
        <!-- Ảnh nền hoa to, sum suê, đầy đặn các loại hoa Peony, Rose, Hydrangea cao cấp không Tulip -->
        <img src="https://i.pinimg.com/736x/6a/07/ff/6a07fff5b3f0c17ff07624d64bf00313.jpg" 
     referrerpolicy="no-referrer"
     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1526047932273-341f2a7631f9?auto=format&fit=crop&w=2000&q=90';" 
     class="position-absolute top-0 start-0 w-100 h-100 aura-hero-img" 
     alt="AURA FLORIST All Flowers Banner">
        <!-- Lớp phủ tối nhẹ lãng mạn, tôn vinh các chi tiết hoa pastel và làm chữ cực kỳ nổi bật -->
        <div class="aura-hero-overlay position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Khối nội dung chính giữa -->
        <div class="container position-relative z-2 text-white px-3 py-5">
            <div class="aura-sub-badge mb-2">
                <span class="aura-line"></span>
                <span class="aura-sub-text">WELCOME TO</span>
                <span class="aura-line"></span>
            </div>

            <h1 class="aura-main-title mb-2">AURA FLORIST</h1>
            
            <p class="aura-slogan mb-3">Nơi những đóa hoa kể chuyện yêu thương</p>
            
            <p class="aura-desc mx-auto mb-4 d-none d-md-block">
                Những thiết kế hoa tinh tế, được tạo nên để lưu giữ những khoảnh khắc đẹp và gửi trao những cảm xúc chân thành.
            </p>

            <a href="#productListArea" class="btn aura-btn-explore rounded-pill px-4 py-2 text-uppercase fw-semibold shadow-sm">
                Khám phá bộ sưu tập &rarr;
            </a>
        </div>
    </div>
</div>

<div class="container py-3" id="productListArea">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item active fw-bold" style="color: #8C6239;">Tất cả sản phẩm</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- ================= BỘ LỌC BÊN TAY TRÁI ================= -->
        <div class="col-lg-3 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 sticky-top" style="top: 20px; background: #FFFDF9;">
                <div class="d-flex justify-content-between align-items-center pb-2 mb-3 border-bottom">
                    <h5 class="fw-bold mb-0" style="color: #4A3525;">
                        <i class="fa-solid fa-filter me-2"></i>Bộ lọc tìm kiếm
                    </h5>
                    <a href="{{ route('products.all') }}" class="text-decoration-none small text-danger">Đặt lại</a>
                </div>

                <form action="{{ route('products.all') }}" method="GET">
                    <!-- 1. Tìm theo từ khóa -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Tìm kiếm tên hoa</label>
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control form-control-sm rounded-start-3" 
                                   placeholder="Nhập tên hoa..." value="{{ request('keyword') }}">
                            <button class="btn btn-sm text-white" style="background: #8C6239;" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- 2. Lọc theo Danh mục -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Danh mục hoa</label>
                        <select name="category_id" class="form-select form-select-sm rounded-3" >
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- 3. Lọc theo Kiểu dáng -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Kiểu dáng thiết kế</label>
                        <select name="style" class="form-select form-select-sm rounded-3" >
                            <option value="">-- Tất cả kiểu dáng --</option>
                            <option value="Bó" {{ request('style') == 'Bó' ? 'selected' : '' }}>Dáng Bó hoa</option>
                            <option value="Hộp" {{ request('style') == 'Hộp' ? 'selected' : '' }}>Dáng Hộp hoa / Mica</option>
                            <option value="Giỏ" {{ request('style') == 'Giỏ' ? 'selected' : '' }}>Dáng Giỏ / Lẵng hoa</option>
                        </select>
                    </div>

                    <!-- 4. Lọc theo Mức giá -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Khoảng giá</label>
                        <div class="d-flex flex-column gap-2 small">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="price_range" id="price_all" value="" 
                                       {{ !request('price_range') ? 'checked' : '' }} >
                                <label class="form-check-label" for="price_all">Tất cả mức giá</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="price_range" id="price_1" value="under_500" 
                                       {{ request('price_range') == 'under_500' ? 'checked' : '' }} >
                                <label class="form-check-label" for="price_1">Dưới 500.000đ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="price_range" id="price_2" value="500_1000" 
                                       {{ request('price_range') == '500_1000' ? 'checked' : '' }} >
                                <label class="form-check-label" for="price_2">500.000đ - 1.000.000đ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="price_range" id="price_3" value="1000_1500" 
                                       {{ request('price_range') == '1000_1500' ? 'checked' : '' }} >
                                <label class="form-check-label" for="price_3">1.000.000đ - 1.500.000đ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="price_range" id="price_4" value="above_1500" 
                                       {{ request('price_range') == 'above_1500' ? 'checked' : '' }} >
                                <label class="form-check-label" for="price_4">Trên 1.500.000đ</label>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Sắp xếp -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Sắp xếp theo</label>
                        <select name="sort" class="form-select form-select-sm rounded-3" >
                            <option value="">Mới nhất</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                            <option value="rating_desc" {{ request('sort') == 'rating_desc' ? 'selected' : '' }}>Đánh giá cao nhất</option>
                        </select>
                    </div>

                    <button type="submit" class="btn w-100 py-2 rounded-3 text-white fw-semibold" style="background: #8C6239;">
                        Áp dụng bộ lọc
                    </button>
                </form>
            </div>
        </div>
        <!-- ================= DANH SÁCH HOA ================= -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-secondary small">
                    Tìm thấy <strong class="text-dark">{{ $products->total() }}</strong> sản phẩm
                </span>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    @php
                        $hasDiscount = isset($product->discount_percent) && $product->discount_percent > 0;
                        $finalPrice = $hasDiscount 
                            ? $product->price * (1 - ($product->discount_percent / 100)) 
                            : $product->price;
                    @endphp

                    <div class="col-xl-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative product-card">
                            
                            <!-- HUY HIỆU KHUYẾN MÃI -->
                            @if($hasDiscount)
                                <div class="position-absolute top-0 end-0 m-2 z-2">
                                    <span class="badge rounded-pill shadow-sm px-2 py-1 text-white fw-bold promo-badge">
                                        <i class="fa-solid fa-bolt me-1"></i>Khuyến mãi
                                    </span>
                                </div>
                            @endif

                            <!-- Ảnh sản phẩm: Gọi trực tiếp Modal của master -->
                            <a href="javascript:void(0)" class="btn-quick-view overflow-hidden d-block position-relative" data-id="{{ $product->id }}" style="height: 260px;">
                                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-100 h-100 object-fit-cover transition-img">
                            </a>

                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge bg-light text-muted fw-normal" style="font-size: 0.75rem;">
                                            {{ $product->category->name ?? 'Hoa tươi' }}
                                        </span>
                                        <span class="text-warning small">
                                            <i class="fa-solid fa-star"></i> {{ number_format($product->rating, 1) }}
                                            <span class="text-muted" style="font-size: 0.7rem;">({{ \App\Models\Review::count() }})</span>
                                        </span>
                                    </div>

                                    <!-- Tên sản phẩm -->
                                    <h6 class="card-title fw-bold mb-2">
                                        <a href="javascript:void(0)" class="btn-quick-view text-decoration-none text-dark product-title-hover" data-id="{{ $product->id }}">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                </div>

                                <!-- KHU VỰC GIÁ VÀ NÚT XEM CHI TIẾT -->
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($hasDiscount)
                                            <div class="fw-bold text-danger fs-6 lh-1 mb-1">
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
                                            <div class="fw-bold text-danger fs-6">
                                                {{ number_format($product->price, 0, ',', '.') }}đ
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Nút gọi thẳng Modal master qua class btn-quick-view -->
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 text-nowrap btn-quick-view" data-id="{{ $product->id }}">
                                        Xem chi tiết
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="p-5 bg-white rounded-4 shadow-sm">
                            <i class="fa-regular fa-face-frown text-muted fs-1 mb-3"></i>
                            <h5 class="text-secondary">Không tìm thấy sản phẩm nào phù hợp với bộ lọc!</h5>
                            <a href="{{ route('products.all') }}" class="btn btn-sm text-white mt-2 px-4 rounded-pill" style="background: #8C6239;">
                                Xem tất cả sản phẩm
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Phân trang Bootstrap 5 (Đã ẩn hoàn toàn dòng chữ Showing ... results) -->
            <div class="mt-4 d-flex justify-content-center clean-pagination">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<style>
/* ================= CSS CHO HERO BANNER LỚN CHUẨN MẪU ================= */
.aura-hero-banner {
    min-height: 500px;
    background-color: #2b1f14;
}
.aura-hero-overlay {
    /* Lớp phủ tối nhẹ chuyển dần từ giữa ra xung quanh giúp chữ trắng cực kỳ rõ nét */
    background: radial-gradient(circle at center, rgba(30, 20, 15, 0.35) 0%, rgba(20, 10, 5, 0.6) 100%);
    z-index: 1;
}

.aura-hero-img {
    object-fit: cover;
    object-position: center bottom; /* Canh để lấy trọn vẹn thảm hoa tulip bung nở phía dưới */
    filter: brightness(0.9);
}
.aura-sub-badge {
    display: inline-flex;
    align-items: center;
    gap: 12px;
}
.aura-line {
    display: inline-block;
    width: 35px;
    height: 1px;
    background-color: rgba(255, 255, 255, 0.7);
}
.aura-sub-text {
    font-size: 0.85rem;
    letter-spacing: 3px;
    font-weight: 600;
    color: #f8f9fa;
}
.aura-main-title {
    font-size: 3.2rem;
    font-weight: 800;
    letter-spacing: 6px;
    text-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
}
.aura-slogan {
    font-size: 1.45rem;
    font-style: italic;
    font-weight: 400;
    color: #fdfaf6;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
}
.aura-desc {
    max-width: 620px;
    font-size: 0.95rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.88);
    text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
}
.aura-btn-explore {
    background-color: #f3eae2;
    color: #5c3d23;
    border: none;
    font-size: 0.85rem;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}
.aura-btn-explore:hover {
    background-color: #8c6239;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}
@media (max-width: 768px) {
    .aura-hero-banner {
        min-height: 360px;
    }
    .aura-main-title {
        font-size: 2.1rem;
        letter-spacing: 3px;
    }
    .aura-slogan {
        font-size: 1.15rem;
    }
}

/* Thẻ sản phẩm */
.product-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}
.transition-img {
    transition: transform 0.35s ease;
}
.product-card:hover .transition-img {
    transform: scale(1.05);
}
.product-title-hover:hover {
    color: #8C6239 !important;
}

/* Huy hiệu hiển thị chữ Khuyến Mãi */
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