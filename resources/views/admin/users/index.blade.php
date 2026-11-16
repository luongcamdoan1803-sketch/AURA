@extends('admin.layouts.app')

@section('title', 'Quản lý Tài Khoản & Khách Hàng')
@section('header_title', 'Quản lý Tài Khoản & Khách Hàng')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--aura-primary-dark); font-family: var(--aura-font-serif);">Quản Lý Người Dùng</h4>
        <p class="text-muted small mb-0">Quản lý danh sách khách hàng đã đăng ký, lịch sử đặt đơn và phân quyền quản trị viên</p>
    </div>
</div>

<!-- THANH TÌM KIẾM & BỘ LỌC -->
<div class="admin-card mb-4">
    <div class="admin-card-body p-3">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0" placeholder="Tìm theo họ tên, email hoặc số điện thoại..." value="{{ request('keyword') }}">
                </div>
            </div>

            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">-- Tất cả vai trò --</option>
                    <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Quản trị viên (Admin)</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-aura flex-grow-1">Lọc</button>
                @if(request()->anyFilled(['keyword', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Đặt lại"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- BẢNG DANH SÁCH NGƯỜI DÙNG -->
<div class="admin-card">
    <div class="admin-card-header">
        <h5 class="admin-card-title">
            <i class="fa-solid fa-users me-2 text-muted"></i>Danh sách tài khoản ({{ $users->total() }})
        </h5>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Họ và tên & Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Đơn hàng đã đặt</th>
                        <th>Ngày tham gia</th>
                        <th style="width: 140px;" class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        @php
                            $isAdmin = (int)$user->role === 1 || $user->role === 'admin';
                        @endphp
                        <tr>
                            <td class="text-muted small">{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                         style="width: 38px; height: 38px; background-color: {{ $isAdmin ? 'var(--aura-primary)' : 'var(--aura-btn-hover)' }}; font-size: 0.9rem;">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->phone)
                                    <span class="text-dark small"><i class="fa-solid fa-phone me-1 text-muted"></i>{{ $user->phone }}</span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">{{ Str::limit($user->address ?? 'Chưa cập nhật', 30) }}</span>
                            </td>
                            <td>
                                @if($isAdmin)
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                        <i class="fa-solid fa-user me-1"></i> Khách hàng
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $user->orders_count }}
                            </td>
                            <td>
                                <span class="text-muted small">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    @if($user->id !== Auth::id())
                                        <!-- Đổi vai trò -->
                                        <form action="{{ route('admin.users.toggleRole', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="{{ $isAdmin ? 'Hạ xuống Khách hàng' : 'Nâng cấp thành Admin' }}">
                                                <i class="fa-solid fa-user-gear"></i>
                                            </button>
                                        </form>

                                        <!-- Xóa người dùng -->
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa tài khoản">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-success-subtle text-success small">Tài khoản bạn</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-user-slash fs-1 mb-3 text-secondary d-block"></i>
                                Không tìm thấy người dùng nào phù hợp.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
        <div class="admin-card-footer p-3 border-top d-flex justify-content-end" style="background-color: var(--aura-bg);">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
