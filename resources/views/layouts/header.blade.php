<!-- Topbar Info & Account -->
<div class="bg-section py-2 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo fw-bold fs-4 text-uppercase tracking-wide" style="letter-spacing: 2px; color: #5a4b41;">
            <a href="{{ url('/') }}" class="text-decoration-none text-dark">
                AURA FLORIST
            </a>
        </div>
        <!-- Thanh tìm kiếm -->
        <div class="w-50 mx-3">
            <form action="{{ route('shop.index') }}" method="GET" class="d-flex">
                <input class="form-control me-2 border-0" type="search" name="keyword" value="{{ request('keyword') }}"
                    placeholder="Nhập tên hoa, danh mục, kiểu dáng..." aria-label="Search">

                <button class="btn btn-aura px-4" type="submit">
                    <i class="bi bi-search"></i>
                    Tìm
                </button>
            </form>
        </div>
        <!-- Tài khoản -->
        <div class="d-flex align-items-center gap-3">
            @guest
                <!-- Chưa đăng nhập -->
                <a href="{{ route('login') }}" class="text-decoration-none text-dark small">
                    <i class="bi bi-person"></i>
                    Đăng nhập
                </a>
                <span class="text-muted">|</span>
                <a href="{{ route('register') }}" class="text-decoration-none text-dark small">
                    Đăng ký
                </a>
            @else
                <!-- Đã đăng nhập -->
                <details class="position-relative">
                    <!-- Tên người dùng -->
                    <summary style="
                                                        cursor: pointer;
                                                        list-style: none;
                                                        color: #2f2a26;
                                                        font-size: 16px;
                                                        white-space: nowrap;
                                                    ">
                        Xin chào! {{ Auth::user()->name }}
                        <span style="font-size: 12px; margin-left: 5px;">
                            ▼
                        </span>
                    </summary>
                    <!-- Menu tài khoản -->
                    <div class="position-absolute bg-white border rounded shadow" style="
                                                        top: 35px;
                                                        right: 0;
                                                        width: 200px;
                                                        z-index: 9999;
                                                    ">
                        <!-- Tài khoản -->
                        <a class="dropdown-item" href="{{ route('account.index') }}">
                            Tài khoản của tôi
                        </a>
                        <!-- Đơn hàng -->
                        <a href="{{ route('orders') }}" class="d-block text-decoration-none text-dark px-3 py-2">
                            Đơn hàng của tôi
                        </a>
                        <!-- Admin -->
                        @if(Auth::user()->role == 1)
                            <a href="#" class="d-block text-decoration-none text-danger px-3 py-2">
                                Trang Quản trị (Admin)
                            </a>
                        @endif
                        <!-- Đường kẻ -->
                        <hr class="my-1">
                        <!-- Đăng xuất -->
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-100 text-start border-0 bg-transparent px-3 py-2"
                                style="cursor: pointer;">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </details>
            @endguest
            <!-- Giỏ hàng -->
            <a href="{{ route('cart.index') }}" class="position-relative text-dark fs-5 ms-2" title="Giỏ hàng">
                <i class="bi bi-cart3"></i>
                <span class="js-cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                    style="font-size: 0.65rem;">{{ app(\App\Services\CartService::class)->count() }}</span>
            </a>
        </div>
    </div>
</div>
<!-- Main Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-light bg-section border-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto aura-main-menu">
                <!-- TRANG CHỦ -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        Trang chủ
                    </a>
                </li>
                <!-- CỬA HÀNG -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('promotion*') ? 'active' : '' }}" href="{{ route('products.all') }}">
                        Cửa hàng
                    </a>
                </li>
                <!-- DANH MỤC -->
                <li class="nav-item dropdown aura-dropdown">
                    <a class="nav-link dropdown-toggle
       {{ request()->is('categories*') ? 'active' : '' }}" href="#">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu aura-dropdown-menu">
                        <!-- HOA THEO DỊP -->
                        <li class="aura-submenu">
                            <a class="dropdown-item aura-submenu-title" href="#">
                                Hoa theo dịp
                                <span class="submenu-arrow">›</span>
                            </a>
                            <ul class="dropdown-menu aura-submenu-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.love') }}">
                                        Hoa tình yêu
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.birthday') }}">
                                        Hoa sinh nhật
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.opening') }}">
                                        Hoa khai trương
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.congrats') }}">
                                        Hoa Chúc mừng
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('shop.wedding') }}">
                                        Hoa cưới
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- HOA THEO MÙA -->
                        <li>
                            <a class="dropdown-item" href="{{ route('shop.season') }}">
                                Hoa theo mùa
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- VỀ CHÚNG TÔI -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        Về chúng tôi
                    </a>
                </li>
                <!-- LIÊN HỆ -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}"
                        href="{{ route('contact.index') }}">
                        Liên hệ
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Đường dẫn cho cart.js (AJAX giỏ hàng) -->
<script>
    window.AURA_ROUTES = {
        add: "{{ route('cart.add') }}",
        update: "{{ route('cart.update') }}",
        remove: "{{ route('cart.remove') }}",
        voucher: "{{ route('cart.voucher') }}",
        checkout: "{{ route('checkout') }}"
    };
</script>
