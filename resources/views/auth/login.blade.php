<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập — AURA FLORIST</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- CSS của website -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <div class="auth-wrap">
        <div class="auth-card">
            <h1>Đăng nhập</h1>
            <p class="sub">
                Chào mừng bạn quay lại AURA FLORIST
            </p>
            <!-- THÔNG BÁO THÀNH CÔNG -->
            @if(session('status'))
                <div class="alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <!-- THÔNG BÁO LỖI -->
            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif
            <!-- FORM ĐĂNG NHẬP -->
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <!-- EMAIL -->
                <div class="form-group">
                    <label for="email">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- MẬT KHẨU -->
                <div class="form-group">
                    <label for="password">
                        Mật khẩu
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                    >
                    @error('password')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <!-- NÚT ĐĂNG NHẬP -->
                <button type="submit" class="btn-primary">
                    Đăng nhập
                </button>
            </form>
            <!-- ĐĂNG KÝ -->
            <p class="switch">
                Chưa có tài khoản?

                <a href="{{ route('register') }}">
                    Đăng ký ngay
                </a>
            </p>
            <!-- QUAY VỀ TRANG CHỦ -->
            <p class="switch">
                <a href="{{ url('/') }}">
                    ← Quay về trang chủ
                </a>
            </p>

        </div>
    </div>

</body>

</html>