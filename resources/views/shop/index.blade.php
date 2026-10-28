@extends('shop.master')

@section('title', 'Cửa Hàng - AURA FLORIST')

@section('content')

<div class="container py-5">

    <!-- Tiêu đề -->
    <div class="text-center mb-5">

        <h6
            class="text-uppercase tracking-wide"
            style="color: #8C6239; letter-spacing: 3px;"
        >
            AURA FLORIST
        </h6>

        @if(request('keyword'))

            <h2 class="fw-bold">
                KẾT QUẢ TÌM KIẾM
            </h2>

            <p class="text-muted mt-3 mb-1">
                Kết quả cho:
                <strong>
                    "{{ request('keyword') }}"
                </strong>
            </p>

            <p class="text-muted">
                Tìm thấy {{ $products->total() }} sản phẩm phù hợp
            </p>

        @else

            <h2 class="fw-bold">
                CỬA HÀNG HOA
            </h2>

            <p class="text-muted mt-3">
                Khám phá các sản phẩm hoa tại Aura Florist
            </p>

        @endif

        <div
            class="mx-auto"
            style="width: 60px; height: 2px; background: #8C6239;"
        ></div>

    </div>


    <!-- Thanh bộ lọc -->
    <div
        class="card p-3 mb-5 border-0 shadow-sm rounded-4"
        style="background: #FFFDF9;"
    >

        <form
            action="{{ route('shop.index') }}"
            method="GET"
            class="row g-3"
        >

            <!-- Tìm theo tên -->
            <div class="col-md-3">

                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Tìm tên hoa..."
                    value="{{ request('keyword') }}"
                >

            </div>


            <!-- Danh mục -->
            <div class="col-md-2">

                <select
                    name="category_id"
                    class="form-select"
                >

                    <option value="">
                        -- Danh mục --
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- Kiểu dáng -->
            <div class="col-md-2">

                <select
                    name="style"
                    class="form-select"
                >

                    <option value="">
                        -- Kiểu dáng --
                    </option>

                    <option
                        value="Bó"
                        {{ request('style') == 'Bó' ? 'selected' : '' }}
                    >
                        Bó hoa
                    </option>

                    <option
                        value="Hộp"
                        {{ request('style') == 'Hộp' ? 'selected' : '' }}
                    >
                        Hộp hoa
                    </option>

                    <option
                        value="Giỏ"
                        {{ request('style') == 'Giỏ' ? 'selected' : '' }}
                    >
                        Giỏ hoa
                    </option>

                </select>

            </div>


            <!-- Mức giá -->
            <div class="col-md-2">

                <select
                    name="price_range"
                    class="form-select"
                >

                    <option value="">
                        -- Mức giá --
                    </option>

                    <option
                        value="under_500"
                        {{ request('price_range') == 'under_500' ? 'selected' : '' }}
                    >
                        Dưới 500k
                    </option>

                    <option
                        value="500_1000"
                        {{ request('price_range') == '500_1000' ? 'selected' : '' }}
                    >
                        500k - 1 triệu
                    </option>

                    <option
                        value="over_1000"
                        {{ request('price_range') == 'over_1000' ? 'selected' : '' }}
                    >
                        Trên 1 triệu
                    </option>

                </select>

            </div>


            <!-- Đánh giá -->
            <div class="col-md-2">

                <select
                    name="rating"
                    class="form-select"
                >

                    <option value="">
                        -- Đánh giá --
                    </option>

                    <option
                        value="5"
                        {{ request('rating') == '5' ? 'selected' : '' }}
                    >
                        ⭐ 5.0
                    </option>

                    <option
                        value="4.8"
                        {{ request('rating') == '4.8' ? 'selected' : '' }}
                    >
                        ⭐ từ 4.8
                    </option>

                </select>

            </div>


            <!-- Nút lọc -->
            <div class="col-md-1 d-grid">

                <button
                    type="submit"
                    class="btn btn-buy-now"
                >
                    <i class="fa fa-filter"></i>
                </button>

            </div>

        </form>

    </div>


    <!-- Lưới sản phẩm -->
    <div class="row g-3 g-lg-4">

        @forelse($products as $product)

            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">

                <div class="flower-card shadow-sm">

                    <!-- Ảnh -->
                    <div class="img-box">

                        <img
                            src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}"
                            alt="{{ $product->name }}"
                        >

                    </div>


                    <!-- Nội dung -->
                    <div class="card-body">

                        <div>

                            <h5
                                class="flower-title"
                                title="{{ $product->name }}"
                            >
                                {{ $product->name }}
                            </h5>


                            <div class="star-box">

                                <i class="fa-solid fa-star text-warning"></i>

                                {{ number_format($product->rating, 1) }}

                                <span class="text-muted small">
                                    ({{ \App\Models\Review::count() }} đánh giá)
                                </span>

                            </div>


                            <div class="flower-price">

                                {{ number_format(
                                    $product->price,
                                    0,
                                    ',',
                                    '.'
                                ) }}đ

                            </div>

                        </div>


                        <!-- Xem chi tiết -->
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


        @empty

            <!-- Không tìm thấy -->
            <div class="col-12">

                <div class="text-center py-5">

                    <i
                        class="bi bi-search"
                        style="
                            font-size: 50px;
                            color: #C5AB88;
                        "
                    ></i>


                    <h5 class="mt-3">
                        Không tìm thấy sản phẩm phù hợp
                    </h5>


                    @if(request('keyword'))

                        <p class="text-muted">
                            Không có sản phẩm phù hợp với từ khóa
                            <strong>
                                "{{ request('keyword') }}"
                            </strong>
                        </p>

                    @else

                        <p class="text-muted">
                            Không có sản phẩm phù hợp với bộ lọc.
                        </p>

                    @endif


                    <a
                        href="{{ route('shop.index') }}"
                        class="btn btn-buy-now mt-2 px-4"
                    >
                        Xem tất cả sản phẩm
                    </a>

                </div>

            </div>

        @endforelse

    </div>


    <!-- Phân trang -->
    @if($products->hasPages())

        <div class="d-flex justify-content-center mt-4">

            {{ $products
                ->appends(request()->query())
                ->links('pagination::bootstrap-5') }}

        </div>

    @endif

</div>

@endsection