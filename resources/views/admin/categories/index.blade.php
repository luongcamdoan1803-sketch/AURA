@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục Hoa')
@section('header_title', 'Quản lý Danh mục Hoa')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Danh Mục Sản Phẩm</h4>
        <p class="text-muted small mb-0">Quản lý phân loại hoa theo kiểu dáng, theo dịp hoặc theo mùa trong cửa hàng</p>
    </div>
    <button type="button" class="btn btn-aura shadow-sm" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="fa-solid fa-plus"></i>
        <span>Thêm danh mục mới</span>
    </button>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fa-solid fa-folder-tree me-2 text-muted"></i>Danh sách danh mục hoa ({{ $categories->count() }})
        </h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 70px;">STT</th>
                        <th>Tên danh mục</th>
                        <th>Đường dẫn (Slug)</th>
                        <th>Nhóm phân loại</th>
                        <th>Số lượng sản phẩm</th>
                        <th style="width: 140px;" class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-bold text-dark">{{ $category->name }}</span>
                            </td>
                            <td>
                                <code>{{ $category->slug }}</code>
                            </td>
                            <td>
                                @if($category->type === 'theo_dip')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Theo dịp</span>
                                @elseif($category->type === 'kieu_dang')
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">Kiểu dáng</span>
                                @else
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Theo mùa</span>
                                @endif
                            </td>
                            <td>
                                {{ $category->products_count }}
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <!-- Nút Sửa -->
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    <!-- Nút Xóa -->
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục \'{{ $category->name }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa danh mục" {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL SỬA DANH MỤC -->
                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header" style="background-color: var(--aura-section); border-bottom: 1px solid var(--aura-border);">
                                        <h5 class="modal-title fw-bold" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Cập nhật Danh mục</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nhóm phân loại <span class="text-danger">*</span></label>
                                                <select name="type" class="form-select" required>
                                                    <option value="theo_dip" {{ old('type', $category->type) === 'theo_dip' ? 'selected' : '' }}>Theo dịp (Tình yêu, Sinh nhật, Chúc mừng,...)</option>
                                                    <option value="kieu_dang" {{ old('type', $category->type) === 'kieu_dang' ? 'selected' : '' }}>Kiểu dáng (Bó hoa, Giỏ hoa, Hộp hoa,...)</option>
                                                    <option value="theo_mua" {{ old('type', $category->type) === 'theo_mua' ? 'selected' : '' }}>Theo mùa (Xuân, Hạ, Thu, Đông,...)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="background-color: var(--aura-bg); border-top: 1px solid var(--aura-border);">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy</button>
                                            <button type="submit" class="btn btn-aura">Lưu thay đổi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-folder-open fs-1 mb-3 text-secondary d-block"></i>
                                Chưa có danh mục nào trong hệ thống.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL THÊM MỚI DANH MỤC -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background-color: var(--aura-section); border-bottom: 1px solid var(--aura-border);">
                <h5 class="modal-title fw-bold" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Thêm Danh mục Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Ví dụ: Hoa tình yêu, Bó hoa sang trọng..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nhóm phân loại <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="theo_dip">Theo dịp (Tình yêu, Sinh nhật, Chúc mừng,...)</option>
                            <option value="kieu_dang">Kiểu dáng (Bó hoa, Giỏ hoa, Hộp hoa,...)</option>
                            <option value="theo_mua">Theo mùa (Xuân, Hạ, Thu, Đông,...)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: var(--aura-bg); border-top: 1px solid var(--aura-border);">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-aura">Tạo danh mục</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
