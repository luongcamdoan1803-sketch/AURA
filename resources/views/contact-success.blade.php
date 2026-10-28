<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảm ơn bạn - AURA FLORIST</title>
    <!-- CSS trang liên hệ -->
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="contact-success-page">
        <div class="contact-success-box">
            <!-- Icon -->
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <!-- Tên shop -->
            <p class="success-small">
                AURA FLORIST
            </p>
            <!-- Tiêu đề -->
            <h1>Cảm ơn bạn!</h1>
            <!-- Nội dung -->
            <p class="success-message">
                Chúng tôi đã nhận được lời nhắn của bạn.
                AURA FLORIST sẽ liên hệ với bạn trong thời gian sớm nhất.
            </p>
            <div class="success-line"></div>
            <!-- Nút về trang chủ -->
            <a href="{{ url('/') }}" class="success-btn">
                <i class="bi bi-house-door me-1"></i>
                Về trang chủ
            </a>
            <!-- Quay lại liên hệ -->
            <a href="{{ route('contact.index') }}" class="success-back">
                <i class="bi bi-arrow-left"></i>
                Quay lại trang liên hệ
            </a>
        </div>
    </div>
</body>
</html>