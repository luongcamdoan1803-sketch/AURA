<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Quản Trị Hệ Thống') | AURA FLORIST</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Admin CSS Quy chuẩn AURA Florist -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        body, html, 
        h1, h2, h3, h4, h5, h6, 
        p, a, 
        button, input, select, textarea, table, th, td {
            font-family: "Times New Roman", Times, serif;
        }

        /* Bảo toàn tuyệt đối font cho Icons (Font Awesome & Bootstrap Icons) */
        i.fa-solid, .fa-solid, i.fas, .fas {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            font-style: normal !important;
        }
        i.fa-regular, .fa-regular, i.far, .far {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }
        i.fa-brands, .fa-brands, i.fab, .fab {
            font-family: "Font Awesome 6 Brands" !important;
            font-weight: 400 !important;
            font-style: normal !important;
        }
        i.bi, .bi, [class^="bi-"], [class*=" bi-"] {
            font-family: "bootstrap-icons" !important;
            font-style: normal !important;
        }
    </style>

    @stack('styles')
</head>

<body class="admin-body">
    <div class="admin-wrapper">
        <!-- SIDEBAR -->
        <aside class="admin-sidebar" id="adminSidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <div class="admin-brand-icon">
                    <i class="fa-solid fa-spa"></i>
                </div>
                <div>
                    <h1 class="admin-brand-title">AURA</h1>
                    <span class="admin-brand-subtitle">Florist Admin</span>
                </div>
            </a>

            <div class="admin-nav">
                <span class="admin-nav-heading">Báo cáo & Thống kê</span>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Tổng quan & Doanh thu</span>
                </a>

                <span class="admin-nav-heading">Quản lý Bán hàng</span>
                <a href="{{ route('admin.orders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Quản lý Đơn hàng</span>
                    @php
                        $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
                    @endphp
                    @if($pendingOrdersCount > 0)
                        <span class="badge bg-danger ms-auto rounded-pill">{{ $pendingOrdersCount }}</span>
                    @endif
                </a>

                <span class="admin-nav-heading">Sản phẩm & Danh mục</span>
                <a href="{{ route('admin.products.index') }}" class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-seedling"></i>
                    <span>Quản lý Sản phẩm</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="admin-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>Danh mục Hoa</span>
                </a>

                <span class="admin-nav-heading">Người dùng & Hệ thống</span>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Khách hàng & Tài khoản</span>
                </a>

                <a href="{{ route('home') }}" class="admin-nav-link" target="_blank">
                    <i class="fa-solid fa-store"></i>
                    <span>Xem Cửa hàng AURA</span>
                    <i class="fa-solid fa-arrow-up-right-from-square ms-auto text-muted small"></i>
                </a>
            </div>

            <div class="admin-sidebar-footer">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar bg-white text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; border: 1px solid var(--aura-border);">
                        <i class="fa-solid fa-user-shield text-muted"></i>
                    </div>
                    <div class="text-truncate">
                        <div class="fw-semibold small text-truncate">{{ Auth::user()->name ?? 'Quản trị viên' }}</div>
                        <div class="text-muted" style="font-size: 0.72rem;">Quản trị viên</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- MAIN SECTION -->
        <div class="admin-main">
            <!-- TOPBAR -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm d-lg-none p-1" id="sidebarToggle" type="button">
                        <i class="fa-solid fa-bars fs-5"></i>
                    </button>
                    <div class="d-none d-md-block">
                        <span class="text-muted small">Khu vực quản trị nội bộ</span>
                        <h6 class="mb-0 fw-bold" style="color: var(--aura-primary-dark);">@yield('header_title', 'Hệ thống Quản Trị AURA Florist')</h6>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary d-none d-sm-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Về trang bán hàng</span>
                    </a>

                    <div class="dropdown">
                        <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" style="background-color: var(--aura-bg); border: 1px solid var(--aura-border);">
                            <span class="badge bg-success rounded-circle p-1"></span>
                            <span class="fw-medium small">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><span class="dropdown-item-text text-muted small">Quyền: Quản trị viên</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        <span>Đăng xuất</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- CONTENT BODY -->
            <main class="admin-content">
                <!-- THÔNG BÁO FLASH SESSION -->
                @if(session('success'))
                    <div class="alert alert-aura-success alert-dismissible fade show p-3 mb-4 d-flex align-items-center gap-2" role="alert">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-aura-error alert-dismissible fade show p-3 mb-4 d-flex align-items-center gap-2" role="alert">
                        <i class="fa-solid fa-circle-exclamation fs-5"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-aura-error alert-dismissible fade show p-3 mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2 mb-2 fw-semibold">
                            <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                            <span>Vui lòng kiểm tra lại các trường thông tin:</span>
                        </div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // Toggle mobile sidebar
        const sidebarToggle = document.getElementById('sidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        if (sidebarToggle && adminSidebar) {
            sidebarToggle.addEventListener('click', function() {
                adminSidebar.classList.toggle('show');
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
