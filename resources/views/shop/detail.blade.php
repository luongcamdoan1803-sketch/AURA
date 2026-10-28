@extends('shop.master')
@section('title', $product->name . ' - AURA FLORIST')

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb điều hướng -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Trang chủ</a>
                </li>
                <li class="breadcrumb-item"><span class="text-muted">{{ $product->category->name ?? 'Hoa tươi' }}</span>
                </li>
                <li class="breadcrumb-item active fw-semibold" style="color: #8C6239;" aria-current="page">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>
        <!-- Khung thông tin chi tiết hoa -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-5" style="background: #FFFDF9;">
            <div class="row g-4 align-items-center">
                <!-- Ảnh hoa -->
                <div class="col-md-5 text-center">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                        alt="{{ $product->name }}" class="img-fluid rounded-4 shadow-sm w-100 object-fit-cover"
                        style="max-height: 450px;">
                </div>
                @php
                    $hasDiscount = isset($product->discount_percent) && $product->discount_percent > 0;
                    $finalPrice = $hasDiscount
                        ? $product->price * (1 - ($product->discount_percent / 100))
                        : $product->price;
                @endphp
                <!-- Chi tiết và giá -->
                <div class="col-md-7">
                    <span class="badge px-3 py-2 rounded-pill mb-2" style="background-color: #F5EBE1; color: #8C6239;">
                        {{ $product->category->name ?? 'Hoa tươi' }} • Kiểu dáng: {{ $product->style ?? 'Bó hoa' }}
                    </span>
                    <h2 class="fw-bold text-dark mb-2">{{ $product->name }}</h2>


                    <!-- Điểm sao và số lượt đánh giá -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="text-warning me-2">
                            <i class="fa-solid fa-star"></i>
                            <span class="fw-bold text-dark ms-1">
                                {{ $reviews->count() > 0 ? number_format($reviews->avg('rating'), 1) : '0.0' }}
                            </span>
                        </div>
                        <span class="text-muted small">
                            ({{ $reviews->count() }} lượt đánh giá)
                        </span>
                    </div>
                    <div class="mb-3">
                        @if($hasDiscount)
                            <!-- Giá mới sau giảm màu đỏ lớn -->
                            <div class="fs-2 fw-bold text-danger lh-1 mb-1">
                                {{ number_format($finalPrice, 0, ',', '.') }}đ
                            </div>
                            <!-- Giá cũ gạch ngang kèm % giảm -->
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-decoration-line-through text-muted fs-5">
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                </span>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold">
                                    Giảm {{ $product->discount_percent }}%
                                </span>
                            </div>
                        @else
                            <div class="fs-2 fw-bold text-danger">
                                {{ number_format($product->price, 0, ',', '.') }}đ
                            </div>
                        @endif
                    </div>

                    <div class="product-description text-secondary mb-4 leading-relaxed">
                        {!! $product->description !!}
                    </div>

                    <div data-product-actions>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="fw-semibold">Số lượng:</span>
                            <div class="qty-box">
                                <button type="button" class="js-detail-minus" aria-label="Giảm">−</button>
                                <input type="number" class="js-detail-qty" value="1" min="1" max="99" aria-label="Số lượng">
                                <button type="button" class="js-detail-plus" aria-label="Tăng">+</button>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-3 js-add-to-cart"
                                data-product-id="{{ $product->id }}">
                                <i class="fa-solid fa-cart-plus me-1"></i> Thêm vào giỏ
                            </button>
                            <button type="button" class="btn btn-buy-now px-4 py-2 rounded-3 js-buy-now"
                                data-product-id="{{ $product->id }}" style="background: #8C6239; color: white;">
                                Mua ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KHU VỰC BÌNH LUẬN & ĐÁNH GIÁ -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="background: #ffffff;">

            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h4 class="fw-bold mb-0" style="color: #4A3525;">
                    <i class="fa-regular fa-comments me-2"></i>
                    Đánh giá từ khách hàng
                </h4>

                <span class="badge bg-light text-dark fs-6">
                    {{ $reviews->count() }} bình luận
                </span>
            </div>

            @if(session('success'))
                <div class="alert alert-success rounded-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Chỉ người đã đăng nhập mới được bình luận -->
            <div class="p-4 rounded-4 mb-4" style="background: #FCF9F5;">
                @auth
                    <h6 class="fw-bold mb-3 text-dark">
                        Bình luận với tài khoản: {{ Auth::user()->name }}
                    </h6>

                    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">
                                Đánh giá sản phẩm
                            </label>

                            <select name="rating" class="form-select" required>
                                <option value="5" selected>⭐⭐⭐⭐⭐ (5 sao)</option>
                                <option value="4">⭐⭐⭐⭐ (4 sao)</option>
                                <option value="3">⭐⭐⭐ (3 sao)</option>
                                <option value="2">⭐⭐ (2 sao)</option>
                                <option value="1">⭐ (1 sao)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">
                                Nội dung bình luận
                            </label>

                            <textarea name="content" rows="3" class="form-control" maxlength="1000"
                                placeholder="Chia sẻ cảm nhận của bạn..." required>{{ old('content') }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn px-4 py-2 rounded-3 text-white fw-semibold"
                                style="background: #8C6239;">
                                <i class="fa fa-paper-plane me-1"></i>
                                Gửi bình luận
                            </button>
                        </div>
                    </form>
                @else
                    <p class="mb-2 text-secondary">
                        Bạn cần đăng nhập để gửi bình luận và đánh giá sản phẩm.
                    </p>

                    <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn text-white rounded-3"
                        style="background: #8C6239;">
                        Đăng nhập để bình luận
                    </a>
                @endauth
            </div>

            <!-- Danh sách bình luận dùng chung cho tất cả hoa -->
            <div class="review-list">
                @forelse($reviews as $rev)
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark">
                                    {{ $rev->user->name ?? 'Tài khoản đã xóa' }}
                                </span>

                                <small class="text-muted">
                                    {{ $rev->created_at
                    ? $rev->created_at->format('d/m/Y H:i')
                    : '' }}
                                </small>
                            </div>

                            <div class="text-warning small mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $rev->rating ? '-solid' : '-regular' }} fa-star"></i>
                                @endfor
                            </div>

                            <p class="mb-0 text-secondary" style="font-size: 0.95rem;">
                                {{ $rev->content }}
                            </p>
                        </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        Chưa có bình luận nào. Hãy là người đầu tiên chia sẻ cảm nhận!
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection