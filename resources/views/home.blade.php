@extends('layouts.app')

@section('title', 'AURA FLORIST - Trang Chủ Hoa Tươi')

@section('content')

<div class="container">

    <!-- 1. HERO BANNER -->
    <div class="aura-full-banner">

        <div class="aura-banner-overlay"></div>

        <div class="aura-banner-content">

            <div class="aura-banner-line"></div>

            <p class="aura-banner-small">
                WELCOME TO
            </p>

            <h1>
                AURA FLORIST
            </h1>

            <p class="aura-banner-message">
                Nơi những đóa hoa kể chuyện yêu thương
            </p>

            <p class="aura-banner-description">
                Những thiết kế hoa tinh tế, được tạo nên
                để lưu giữ những khoảnh khắc đẹp và gửi trao
                những cảm xúc chân thành.
            </p>

            <a href="{{ route('products.all') }}" class="hero-btn">
                KHÁM PHÁ BỘ SƯU TẬP
                <i class="bi bi-arrow-right ms-2"></i>
            </a>

        </div>

    </div>
    <!-- 2. THÔNG ĐIỆP / GIỚI THIỆU SHOP -->
    <div class="aura-features mb-5">

        <div class="row g-4">

            <!-- ITEM 01 -->
            <div class="col-md-4">

                <div class="aura-feature-box aura-feature-box-1">

                    <div class="aura-feature-top">

                        <span class="aura-feature-number">01</span>

                        <div class="aura-feature-icon">
                            <i class="bi bi-flower1"></i>
                        </div>

                    </div>

                    <div class="aura-feature-content">

                        <h5>Hoa tươi mỗi ngày</h5>

                        <p>
                            Tuyển chọn những đóa hoa tươi mới,
                            đẹp và chất lượng mỗi ngày.
                        </p>

                    </div>

                </div>

            </div>


            <!-- ITEM 02 -->
            <div class="col-md-4">

                <div class="aura-feature-box aura-feature-box-2">

                    <div class="aura-feature-top">

                        <span class="aura-feature-number">02</span>

                        <div class="aura-feature-icon">
                            <i class="bi bi-truck"></i>
                        </div>

                    </div>

                    <div class="aura-feature-content">

                        <h5>Giao hoa nhanh chóng</h5>

                        <p>
                            Đóng gói cẩn thận, giao tận tay
                            để hoa luôn giữ được vẻ đẹp ban đầu.
                        </p>

                    </div>

                </div>

            </div>


            <!-- ITEM 03 -->
            <div class="col-md-4">

                <div class="aura-feature-box aura-feature-box-3">

                    <div class="aura-feature-top">

                        <span class="aura-feature-number">03</span>

                        <div class="aura-feature-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>

                    </div>

                    <div class="aura-feature-content">

                        <h5>Thiết kế theo yêu cầu</h5>

                        <p>
                            Mỗi bó hoa được chăm chút riêng
                            để phù hợp với câu chuyện của bạn.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- 3. SẢN PHẨM NỔI BẬT -->
    <div id="featured-products" class="aura-section-title">

        <div class="aura-title-top">
            <span></span>
            <i class="bi bi-flower1"></i>
            <span></span>
        </div>

        <p class="aura-title-label">
            AURA COLLECTION
        </p>

        <h2>
            SẢN PHẨM NỔI BẬT
        </h2>

        <p class="aura-title-description">
            Những thiết kế hoa được yêu thích và lựa chọn nhiều nhất tại Aura Florist
        </p>

    </div>


    <div class="row g-3 g-lg-4 mb-5">

        @foreach($featuredProducts as $product)

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">

                <div class="flower-card shadow-sm">

                    <div class="img-box">

                        <img
                            src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                            alt="{{ $product->name }}"
                        >

                    </div>

                    <div class="card-body">

                        <div>

                            <h5 class="flower-title" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>

                            <div class="star-box">

                                <i class="fa-solid fa-star text-warning"></i>

                                {{ number_format(number_format($globalAverageRating, 1), 1) }}

                                <span class="text-muted small">
                                    ({{ $globalReviewCount }} đánh giá)
                                </span>

                            </div>

                            <div class="flower-price">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </div>

                        </div>

                        <button
                            class="btn btn-detail mt-2 btn-quick-view"
                            data-id="{{ $product->id }}"
                        >
                            <i class="fa-regular fa-eye me-1"></i>
                            Xem chi tiết
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>


    <!-- 4. SẢN PHẨM MỚI -->
    <div class="aura-section-title">

        <div class="aura-title-top">
            <span></span>
            <i class="bi bi-flower1"></i>
            <span></span>
        </div>

        <p class="aura-title-label">
            AURA COLLECTION
        </p>

        <h2>
            SẢN PHẨM MỚI
        </h2>

        <p class="aura-title-description">
            Những sản phẩm mới nhất tại Aura Florist
        </p>

    </div>

    <div class="row g-3 g-lg-4 mb-5">

        @foreach($newProducts as $product)

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="flower-card shadow-sm">
                    <div class="img-box">
                        <img
                            src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                            alt="{{ $product->name }}"
                        >

                    </div>

                    <div class="card-body">

                        <div>

                            <h5 class="flower-title" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>

                            <div class="star-box">

                                <i class="fa-solid fa-star text-warning"></i>

                                {{ number_format($globalAverageRating, 1) }}

                                <span class="text-muted small">
                                    ({{ $globalReviewCount }} đánh giá)
                                </span>

                            </div>

                            <div class="flower-price">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </div>

                        </div>

                        <button
                            class="btn btn-detail mt-2 btn-quick-view"
                            data-id="{{ $product->id }}"
                        >
                            <i class="fa-regular fa-eye me-1"></i>
                            Xem chi tiết
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <!-- 5. SẢN PHẨM BÁN CHẠY -->
    <div class="aura-section-title">

        <div class="aura-title-top">
            <span></span>
            <i class="bi bi-flower1"></i>
            <span></span>
        </div>

        <p class="aura-title-label">
            AURA COLLECTION
        </p>

        <h2>
            SẢN PHẨM BÁN CHẠY
        </h2>

        <p class="aura-title-description">
            Những thiết kế hoa được khách hàng lựa chọn nhiều tại Aura Florist
        </p>

    </div>


    <div class="row g-3 g-lg-4 mb-5">

        @foreach($bestSellers as $product)

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">

                <div class="flower-card shadow-sm">

                    <div class="img-box">

                        <img
                            src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                            alt="{{ $product->name }}"
                        >

                    </div>

                    <div class="card-body">

                        <div>

                            <h5 class="flower-title" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>

                            <div class="star-box">

                                <i class="fa-solid fa-star text-warning"></i>

                                {{ number_format(number_format($globalAverageRating, 1), 1) }}

                                <span class="text-muted small">
                                    ({{ $globalReviewCount }} đánh giá)
                                </span>

                            </div>

                            <div class="flower-price">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </div>

                        </div>

                        <button
                            class="btn btn-detail mt-2 btn-quick-view"
                            data-id="{{ $product->id }}"
                        >
                            <i class="fa-regular fa-eye me-1"></i>
                            Xem chi tiết
                        </button>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection