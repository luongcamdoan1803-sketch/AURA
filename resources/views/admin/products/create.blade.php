@extends('admin.layouts.app')

@section('title', 'Thêm Sản Phẩm Hoa Mới')
@section('header_title', 'Thêm Sản Phẩm Hoa Mới')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-2">
        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách hoa
    </a>
    <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Thêm Hoa Mới Vào Cửa Hàng</h4>
    <p class="text-muted small mb-0">Nhập đầy đủ thông tin chi tiết để niêm yết mẫu hoa lên website AURA Florist</p>
</div>

<div class="row">
    <div class="col-lg-9 col-xl-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title"><i class="fa-solid fa-info-circle me-2 text-muted"></i>Thông tin cơ bản</h5>
                </div>
                <div class="admin-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên mẫu hoa <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ví dụ: Bó hoa Hồng Pastel Sweet, Giỏ hoa Grand Opening..." value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Danh mục hoa <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <option value="">-- Không phân loại / Tự do --</option>
                                <option value="bo" {{ old('style') === 'bo' ? 'selected' : '' }}>Bó hoa</option>
                                <option value="gio" {{ old('style') === 'gio' ? 'selected' : '' }}>Giỏ hoa</option>
                                <option value="hop" {{ old('style') === 'hop' ? 'selected' : '' }}>Hộp hoa</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Giá bán niêm yết (VNĐ) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Ví dụ: 450000" value="{{ old('price') }}" min="0" required>
                                <span class="input-group-text bg-white">đ</span>
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Khuyến mãi / Giảm giá (%)</label>
                            <div class="input-group">
                                <input type="number" name="discount_percent" class="form-control @error('discount_percent') is-invalid @enderror" placeholder="0" value="{{ old('discount_percent', 0) }}" min="0" max="100">
                                <span class="input-group-text bg-white">%</span>
                            </div>
                            @error('discount_percent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả ý nghĩa & Thành phần hoa</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Mô tả các loại hoa sử dụng, ý nghĩa màu sắc, dịp phù hợp để tặng...">{{ old('description') }}</textarea>
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
                            <i class="fa-solid fa-camera fs-2 text-muted" id="placeholderIcon"></i>
                            <img src="" alt="Xem trước ảnh" id="imagePreview" style="display: none;">
                        </div>

                        <div class="flex-grow-1">
                            <label class="form-label fw-semibold">Chọn file ảnh tải lên</label>
                            <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <div class="form-text small text-muted">
                                Hỗ trợ: JPG, PNG, WEBP. Ảnh sẽ được tự động lưu vào <code>public/images/</code> theo quy định dự án.
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
                    <span>Lưu sản phẩm</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image on change
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const placeholderIcon = document.getElementById('placeholderIcon');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    imagePreview.src = evt.target.result;
                    imagePreview.style.display = 'block';
                    placeholderIcon.style.display = 'none';
                };
                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endpush
