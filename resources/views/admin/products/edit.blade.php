@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Sản Phẩm Hoa')
@section('header_title', 'Chỉnh sửa Sản Phẩm Hoa')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách hoa
    </a>
    <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Chỉnh Sửa Mẫu Hoa: {{ $product->name }}</h4>
    <p class="text-muted small mb-0">Cập nhật giá bán, danh mục, tỷ lệ giảm giá hoặc thay đổi hình ảnh</p>
</div>

<div class="row">
    <div class="col-lg-9 col-xl-8">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><i class="fa-solid fa-info-circle me-2 text-muted"></i>Thông tin hoa</h5>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên mẫu hoa <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Danh mục hoa <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kiểu dáng thiết kế</label>
                            <select name="style" class="form-select">
                                <option value="" {{ old('style', $product->style) == null ? 'selected' : '' }}>-- Không phân loại / Tự do --</option>
                                <option value="bo" {{ old('style', $product->style) === 'bo' ? 'selected' : '' }}>Bó hoa</option>
                                <option value="gio" {{ old('style', $product->style) === 'gio' ? 'selected' : '' }}>Giỏ hoa</option>
                                <option value="hop" {{ old('style', $product->style) === 'hop' ? 'selected' : '' }}>Hộp hoa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá bán niêm yết (VNĐ) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', (int)$product->price) }}" min="0" required>
                                <span class="input-group-text bg-white">đ</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Khuyến mãi / Giảm giá (%)</label>
                            <div class="input-group">
                                <input type="number" name="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100">
                                <span class="input-group-text bg-white">%</span>
                            </div>
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả ý nghĩa & Thành phần hoa</label>
                        <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- HÌNH ẢNH HOA -->
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><i class="fa-solid fa-image me-2 text-muted"></i>Hình ảnh sản phẩm</h5>
                </div>
                <div class="admin-card-body">
                    <div class="d-flex flex-wrap gap-4 align-items-center">
                        <div class="preview-image-box shadow-sm" id="imagePreviewBox">
                            @php
                                $imgSrc = file_exists(public_path('images/' . $product->image)) 
                                    ? asset('images/' . $product->image) 
                                    : asset('images/default.jpg');
                            @endphp
                            <img src="{{ $imgSrc }}" alt="{{ $product->name }}" id="imagePreview" onerror="this.src='https://placehold.co/140x140?text=AURA';">
                        </div>

                        <div class="flex-grow-1">
                            <label class="form-label fw-semibold">Chọn ảnh mới (để trống nếu giữ nguyên ảnh hiện tại)</label>
                            <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <div class="form-text small text-muted">
                                Tên file ảnh hiện tại: <code>{{ $product->image }}</code>
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- NÚT HÀNH ĐỘNG -->
            <div class="d-flex align-items-center justify-content-end gap-3 mb-5">
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                <button type="submit" class="btn btn-aura px-4 shadow-sm">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Cập nhật sản phẩm</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    imagePreview.src = evt.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endpush
