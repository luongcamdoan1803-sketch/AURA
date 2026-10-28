@extends('layouts.account')

@section('title', 'Tài khoản của tôi — AURA FLORIST')

@section('content')

<a href="{{ url('/') }}"
   class="account-home-link">
    <i class="bi bi-arrow-left"></i>
    Trở về trang chủ
</a>

<div class="account-page">
    <div class="container">

        <!-- TIÊU ĐỀ -->
        <div class="account-heading">
            <p class="account-label">
                AURA FLORIST
            </p>

            <h1>TÀI KHOẢN CỦA TÔI</h1>

            <div class="account-decoration">
                <span></span>
                <i class="bi bi-person"></i>
                <span></span>
            </div>

            <p class="account-description">
                Quản lý thông tin cá nhân và bảo mật tài khoản của bạn.
            </p>
        </div>

        <!-- THÔNG BÁO THÀNH CÔNG -->
        @if(session('success'))
            <div class="account-alert success">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- KHUNG TÀI KHOẢN -->
        <div class="account-card">

            <!-- THÔNG TIN CÁ NHÂN -->
            <div class="account-section">
                <div class="account-section-title">
                    <div>
                        <span>THÔNG TIN</span>
                        <h2>Thông tin cá nhân</h2>
                    </div>

                    <div class="account-title-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                </div>

                <!-- DANH SÁCH THÔNG TIN -->
                <div class="account-info-list">

                    <!-- HỌ VÀ TÊN -->
                    <div class="account-info-row">
                        <div class="account-info-icon">
                            <i class="bi bi-person"></i>
                        </div>

                        <div class="account-info-content">
                            <span>Họ và tên</span>

                            <strong>
                                {{ Auth::user()->name }}
                            </strong>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="account-info-row">
                        <div class="account-info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>

                        <div class="account-info-content">
                            <span>Email</span>

                            <strong>
                                {{ Auth::user()->email }}
                            </strong>
                        </div>
                    </div>

                    <!-- SỐ ĐIỆN THOẠI -->
                    <div class="account-info-row">
                        <div class="account-info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>

                        <div class="account-info-content">
                            <span>Số điện thoại</span>

                            <strong>
                                {{ Auth::user()->phone ?: 'Chưa cập nhật' }}
                            </strong>
                        </div>
                    </div>

                </div>

                <!-- NÚT CHỈNH SỬA -->
                <div class="account-action">
                    <a href="{{ route('account.edit') }}"
                       class="account-btn">
                        <i class="bi bi-pencil-square"></i>
                        Chỉnh sửa thông tin
                    </a>
                </div>
            </div>

            <!-- BẢO MẬT -->
            <div class="account-section security-section">
                <div class="account-section-title">
                    <div>
                        <span>BẢO MẬT</span>
                        <h2>Bảo mật tài khoản</h2>
                    </div>

                    <div class="account-title-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>

                <div class="security-content">
                    <div class="security-info">
                        <div class="security-icon">
                            <i class="bi bi-key"></i>
                        </div>

                        <div>
                            <span>Mật khẩu</span>

                            <div class="password-dots">
                                ••••••••••
                            </div>

                            <p>
                                Bạn nên sử dụng mật khẩu mạnh và
                                không chia sẻ mật khẩu với người khác.
                            </p>
                        </div>
                    </div>

                    <!-- NÚT MỞ POPUP -->
                    <button type="button"
                            class="password-btn"
                            id="openPasswordModal">
                        <i class="bi bi-lock"></i>
                        Đổi mật khẩu
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- POPUP ĐỔI MẬT KHẨU -->
<div class="password-modal-overlay"
     id="passwordModal">

    <div class="password-modal-card">

        <!-- HEADER POPUP -->
        <div class="password-modal-header">
            <div>
                <span class="password-modal-label">
                    BẢO MẬT TÀI KHOẢN
                </span>

                <h3>
                    Đổi mật khẩu
                </h3>
            </div>

            <!-- DẤU X -->
            <button type="button"
                    class="password-modal-close"
                    id="closePasswordModal">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <p class="password-modal-description">
            Nhập mật khẩu hiện tại và thiết lập
            mật khẩu mới cho tài khoản.
        </p>

        <!-- FORM ĐỔI MẬT KHẨU -->
        <form action="{{ route('account.password.update') }}"
              method="POST">

            @csrf
            @method('PUT')

            <!-- MẬT KHẨU HIỆN TẠI -->
            <div class="account-form-group">
                <label for="current_password">
                    Mật khẩu hiện tại
                </label>

                <div class="password-input">
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           placeholder="Nhập mật khẩu hiện tại">

                    <button type="button"
                            class="toggle-password"
                            data-target="current_password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                @error('current_password')
                    <div class="account-error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- MẬT KHẨU MỚI -->
            <div class="account-form-group">
                <label for="password">
                    Mật khẩu mới
                </label>

                <div class="password-input">
                    <input type="password"
                           id="password"
                           name="password"
                           placeholder="Nhập mật khẩu mới">

                    <button type="button"
                            class="toggle-password"
                            data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                @error('password')
                    <div class="account-error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- XÁC NHẬN MẬT KHẨU -->
            <div class="account-form-group">
                <label for="password_confirmation">
                    Xác nhận mật khẩu mới
                </label>

                <div class="password-input">
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           placeholder="Nhập lại mật khẩu mới">

                    <button type="button"
                            class="toggle-password"
                            data-target="password_confirmation">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- BUTTON -->
            <div class="password-modal-actions">
                <button type="button"
                        class="password-cancel-btn"
                        id="cancelPasswordModal">
                    Hủy
                </button>

                <button type="submit"
                        class="password-save-btn">
                    <i class="bi bi-shield-check"></i>
                    Đổi mật khẩu
                </button>
            </div>

        </form>

    </div>
</div>

<!-- JAVASCRIPT POPUP -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal =
        document.getElementById('passwordModal');

    const openButton =
        document.getElementById('openPasswordModal');

    const closeButton =
        document.getElementById('closePasswordModal');

    const cancelButton =
        document.getElementById('cancelPasswordModal');

    /* MỞ POPUP */
    openButton.addEventListener('click', function () {
        modal.classList.add('show');
        document.body.classList.add('modal-open');
    });

    /* ĐÓNG POPUP */
    function closePasswordModal() {
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    }

    /* DẤU X */
    closeButton.addEventListener(
        'click',
        closePasswordModal
    );

    /* NÚT HỦY */
    cancelButton.addEventListener(
        'click',
        closePasswordModal
    );

    /* BẤM RA NGOÀI POPUP */
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closePasswordModal();
        }
    });

    /* HIỆN / ẨN MẬT KHẨU */
    document
        .querySelectorAll('.toggle-password')
        .forEach(function (button) {
            button.addEventListener('click', function () {
                const target =
                    this.getAttribute('data-target');

                const input =
                    document.getElementById(target);

                const icon =
                    this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';

                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';

                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });

    /* NẾU ĐỔI MẬT KHẨU BỊ LỖI - TỰ ĐỘNG MỞ LẠI POPUP */
    @if(
        $errors->has('current_password') ||
        $errors->has('password')
    )
        modal.classList.add('show');
        document.body.classList.add('modal-open');
    @endif
});
</script>

@endsection