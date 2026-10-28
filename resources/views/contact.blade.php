@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush
@section('title', 'Liên hệ — AURA FLORIST')
@section('content')
<!-- HERO LIÊN HỆ -->
<section class="contact-hero">
    <div class="container">
        <div class="row align-items-center">
            <!-- Nội dung -->
            <div class="col-lg-7">
                <span class="contact-small-title">
                    AURA FLORIST
                </span>
                <h1>
                    Hãy để chúng tôi
                    <span>nghe câu chuyện</span>
                    của bạn
                </h1>
                <p>
                    Bạn đang tìm một bó hoa cho người đặc biệt?
                    Hay cần tư vấn để lựa chọn món quà thật ý nghĩa?
                    Hãy để AURA FLORIST đồng hành cùng bạn.
                </p>
                <a href="#contact-form" class="contact-main-btn">
                    Gửi lời nhắn
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- DỊCH VỤ -->
<section class="contact-services">
    <div class="container">
        <div class="text-center section-heading">
            <span>
                WE ARE HERE FOR YOU
            </span>
            <h2>
                AURA có thể giúp gì cho bạn?
            </h2>
        </div>
        <div class="row g-4">
            <!-- Dịch vụ 1 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-flower1"></i>
                    </div>
                    <h3>
                        Tư vấn chọn hoa
                    </h3>
                    <p>
                        Chưa biết nên chọn hoa gì?
                        Chúng tôi sẽ giúp bạn lựa chọn
                        theo dịp, người nhận và thông điệp
                        bạn muốn gửi gắm.
                    </p>
                    <span class="service-number">
                        01
                    </span>
                </div>
            </div>
            <!-- Dịch vụ 2 -->
            <div class="col-md-4">
                <div class="service-card service-card-active">
                    <div class="service-icon">
                        <i class="bi bi-gift"></i>
                    </div>
                    <h3>
                        Đặt hoa theo yêu cầu
                    </h3>
                    <p>
                        Bạn có ý tưởng riêng?
                        AURA FLORIST có thể thiết kế
                        những bó hoa theo màu sắc,
                        kiểu dáng và phong cách bạn mong muốn.
                    </p>
                    <span class="service-number">
                        02
                    </span>
                </div>
            </div>
            <!-- Dịch vụ 3 -->
            <div class="col-md-4">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h3>
                        Giao hoa tận nơi
                    </h3>
                    <p>
                        Gửi yêu thương đến bất cứ đâu.
                        AURA hỗ trợ giao hoa tận nơi
                        để món quà của bạn đến tay người nhận
                        thật trọn vẹn.
                    </p>
                    <span class="service-number">
                        03
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- CONTACT + FORM -->
<section class="contact-main" id="contact-form">
    <div class="container">
        <div class="row g-0 contact-box">
            <!-- Thông tin -->
            <div class="col-lg-5">
                <div class="contact-info">
                    <span class="contact-label">
                        GET IN TOUCH
                    </span>
                    <h2>
                        Kết nối với
                        <span>AURA</span>
                    </h2>
                    <p>
                        Nếu bạn cần đặt thiết kế riêng hoặc có bất cứ phản hồi gì về sản phẩm bạn có thể liên hệ với chúng tôi
                    </p>
                    <!-- Địa chỉ -->
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div>
                            <small>
                                Địa chỉ
                            </small>
                            <p>
                                Thành phố Hồ Chí Minh, Việt Nam
                            </p>
                        </div>
                    </div>
                    <!-- Điện thoại -->
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div>
                            <small>
                                Điện thoại
                            </small>
                            <p>
                                0900 123 456
                            </p>
                        </div>
                    </div>
                    <!-- Email -->
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div>
                            <small>
                                Email
                            </small>
                            <p>
                                support@auraflorist.com
                            </p>
                        </div>
                    </div>
                    <!-- Thời gian -->
                    <div class="contact-item">
                        <div class="contact-item-icon">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <small>
                                Giờ hoạt động
                            </small>
                            <p>
                                08:00 – 21:00 | Thứ 2 – Chủ nhật
                            </p>
                        </div>
                    </div>
                    <!-- Social -->
                    <div class="contact-social">
                        <a href="#">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <div class="col-lg-7">
                <div class="contact-form">
                    <span class="contact-label">
                        SEND A MESSAGE
                    </span>
                    <h2>
                        Gửi lời nhắn cho chúng tôi
                    </h2>
                    <p>
                        Hãy để lại thông tin, AURA sẽ liên hệ với bạn
                        sớm nhất có thể.
                    </p>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Họ tên -->
                            <div class="col-md-6">
                                <div class="contact-input">
                                    <label for="name">
                                        Họ và tên
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        placeholder="Nhập họ và tên"
                                        required
                                    >
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="contact-input">
                                    <label for="email">
                                        Email
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        placeholder="example@gmail.com"
                                        required
                                    >
                                </div>
                            </div>
                            <!-- Số điện thoại -->
                            <div class="col-md-6">
                                <div class="contact-input">
                                    <label for="phone">
                                        Số điện thoại
                                    </label>
                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        placeholder="Nhập số điện thoại"
                                    >
                                </div>
                            </div>
                            <!-- Chủ đề -->
                            <div class="col-md-6">
                                <div class="contact-input">
                                    <label for="subject">
                                        Bạn cần hỗ trợ về
                                    </label>
                                    <select
                                        id="subject"
                                        name="subject"
                                    >
                                        <option value="">
                                            Chọn nội dung
                                        </option>
                                        <option value="tu-van">
                                            Tư vấn chọn hoa
                                        </option>
                                        <option value="dat-hoa">
                                            Đặt hoa theo yêu cầu
                                        </option>
                                        <option value="don-hang">
                                            Hỏi về đơn hàng
                                        </option>
                                        <option value="khac">
                                            Nội dung khác
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Nội dung -->
                            <div class="col-12">
                                <div class="contact-input">
                                    <label for="message">
                                        Lời nhắn
                                    </label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        rows="5"
                                        placeholder="Hãy chia sẻ điều bạn muốn gửi đến AURA..."
                                        required
                                    ></textarea>
                                </div>
                            </div>
                            <!-- Button -->
                            <div class="col-12">
                                <button
                                    type="submit"
                                    class="contact-submit"
                                >
                                    Gửi lời nhắn
                                    <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</section>
@endsection