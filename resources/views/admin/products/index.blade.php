@extends('admin.layouts.app')

@section('title', 'Quản lý Sản phẩm Hoa')
@section('header_title', 'Quản lý Sản phẩm Hoa')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Quản Lý
                Sản Phẩm Hoa</h4>
            <p class="text-muted small mb-0">Quản lý kho hoa tươi, giá bán, danh mục và hình ảnh hiển thị trên AURA Florist
            </p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-aura shadow-sm">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm hoa mới</span>
        </a>
    </div>

    <!-- THANH TÌM KIẾM & BỘ LỌC -->
    <div class="admin-card mb-4">
        <div class="admin-card-body p-3">
            <form action="{{ route('admin.products.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="keyword" class="form-control border-start-0"
                            placeholder="Tìm theo tên sản phẩm hoa..." value="{{ request('keyword') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">-- Tất cả danh mục hoa --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="style" class="form-select">
                        <option value="">-- Tất cả kiểu dáng --</option>
                        <option value="bo" {{ request('style') === 'bo' ? 'selected' : '' }}>Bó hoa</option>
                        <option value="gio" {{ request('style') === 'gio' ? 'selected' : '' }}>Giỏ hoa</option>
                        <option value="hop" {{ request('style') === 'hop' ? 'selected' : '' }}>Hộp hoa</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-aura flex-grow-1">Lọc</button>
                    @if(request()->anyFilled(['keyword', 'category_id', 'style']))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary"
                            title="Đặt lại bộ lọc"><i class="fa-solid fa-rotate-left"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- BẢNG DANH SÁCH HOA -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h5 class="admin-card-title">
                <i class="fa-solid fa-seedling me-2 text-muted"></i>Danh sách hoa ({{ $products->total() }} sản phẩm)
            </h5>
        </div>
        <div class="admin-card-body p-0">
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Hình ảnh</th>
                            <th>Tên sản phẩm & Mã</th>
                            <th>Danh mục</th>
                            <th>Kiểu dáng</th>
                            <th>Giá bán niêm yết</th>
                            <th>Giảm giá</th>
                            <th>Đánh giá</th>
                            <th style="width: 130px;" class="text-end">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="flower-thumb"
                                        onerror="this.onerror=null; this.src='{{ asset('images/about-flower.jpg') }}';">
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                    <div class="text-muted small"><code>{{ $product->slug }}</code></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        {{ $product->category->name ?? 'Chưa phân loại' }}
                                    </span>
                                </td>
                                <td>
                                    @if($product->style === 'bo')
                                        <span class="badge bg-info-subtle text-info-emphasis">Bó hoa</span>
                                    @elseif($product->style === 'gio')
                                        <span class="badge bg-success-subtle text-success-emphasis">Giỏ hoa</span>
                                    @elseif($product->style === 'hop')
                                        <span class="badge bg-warning-subtle text-warning-emphasis">Hộp hoa</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->discount_percent > 0)
                                        <div class="fw-bold text-danger">{{ number_format($product->final_price, 0, ',', '.') }} đ
                                        </div>
                                        <small
                                            class="text-decoration-line-through text-muted">{{ number_format($product->price, 0, ',', '.') }}
                                            đ</small>
                                    @else
                                        <div class="fw-bold text-dark">{{ number_format($product->price, 0, ',', '.') }} đ</div>
                                    @endif
                                </td>
                                <td>
                                    @if($product->discount_percent > 0)
                                        <span class="badge bg-danger rounded-pill">-{{ $product->discount_percent }}%</span>
                                    @else
                                        <span class="text-muted small">0%</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-warning small">
                                        <i class="fa-solid fa-star"></i>
                                        {{ $product->reviews->count() > 0 ? number_format($product->reviews->avg('rating'), 1) : '0.0' }}
                                    </span>
                                    <div class="text-muted small">
                                        {{ $product->reviews->count() }} đánh giá
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Chỉnh sửa hoa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm hoa \'{{ $product->name }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa hoa">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open fs-1 mb-3 text-secondary d-block"></i>
                                    Không tìm thấy sản phẩm hoa nào phù hợp với bộ lọc.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="admin-card-footer p-3 border-top d-flex justify-content-end" style="background-color: var(--aura-bg);">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection