<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Đăng ký — AURA FLORIST</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS của website -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>

<body>
    <div class="auth-wrap">
        <div class="auth-card">
            <h1>Tạo tài khoản</h1>

            <p class="sub">
                Đăng ký để lưu địa chỉ và theo dõi đơn hàng dễ dàng hơn
            </p>

            <!-- FORM ĐĂNG KÝ -->
            <form action="{{ route('register.submit') }}" method="POST">
                @csrf

                <!-- HỌ VÀ TÊN -->
                <div class="form-group">
                    <label for="name">
                        Họ và tên
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                    >

                    @error('name')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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
                    >

                    @error('email')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- SỐ ĐIỆN THOẠI -->
                <div class="form-group">
                    <label for="phone">
                        Số điện thoại
                    </label>

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone') }}"
                    >

                    @error('phone')
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

                <!-- NHẬP LẠI MẬT KHẨU -->
                <div class="form-group">
                    <label for="password_confirmation">
                        Nhập lại mật khẩu
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                    >
                </div>

                <!-- NÚT ĐĂNG KÝ -->
                <button type="submit" class="btn-primary">
                    Đăng ký
                </button>
            </form>

            <!-- CHUYỂN SANG ĐĂNG NHẬP -->
            <p class="switch">
                Đã có tài khoản?

                <a href="{{ route('login') }}">
                    Đăng nhập
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