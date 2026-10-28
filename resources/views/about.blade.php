@extends('layouts.app')
@section('title', 'Về chúng tôi — AURA FLORIST')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush
@section('content')
    <!-- HERO -->
    <section class="about-hero">
        <div class="about-hero-overlay"></div>
        <div class="container about-hero-content">
            <p class="about-label">AURA FLORIST</p>
            <h1>
                Nơi mỗi bó hoa<br>
                <span>kể một câu chuyện</span>
            </h1>
            <p class="about-hero-text">
                Chúng tôi tin rằng hoa không chỉ là một món quà,
                mà còn là cách để bạn gửi gắm yêu thương.
            </p>
            <a href="{{ route('products.index') }}" class="about-btn">
                Khám phá bộ sưu tập
                <span>→</span>
            </a>
        </div>
    </section>
    <!-- STORY -->
    <section class="about-story">
        <div class="container">
            <div class="story-grid">
                <div class="story-image">
                    <div class="image-frame">
                        <img src="{{ asset('images/about-flower.jpg') }}" alt="Hoa AURA FLORIST">
                    </div>
                </div>
                <div class="story-content">
                    <p class="section-label">CÂU CHUYỆN CỦA CHÚNG TÔI</p>
                    <h2>
                        Hoa được chọn kỹ,<br>thiết kế một cách chỉn chu
                    </h2>
                    <p>
                        AURA FLORIST được xây dựng với mong muốn mang đến những sản phẩm hoa có thiết kế đẹp, chỉn chu và
                        phù hợp với nhiều dịp khác nhau.
                    </p>
                    <p>
                        Chúng tôi chú trọng từ việc lựa chọn hoa, phối màu đến cách hoàn thiện từng sản phẩm. Mỗi bó hoa,
                        giỏ hoa hay hộp hoa đều được thiết kế với sự cân bằng giữa thẩm mỹ, chất lượng và nhu cầu của người
                        nhận.
                    </p>
                    <p>
                        Từ hoa sinh nhật, hoa chúc mừng đến những thiết kế dành cho các dịp đặc biệt, AURA FLORIST hướng đến
                        phong cách hiện đại, tinh tế và dễ lựa chọn — để hoa không chỉ đẹp khi trao đi mà còn phù hợp với
                        từng khoảnh khắc.
                    </p>
                    <div class="story-signature">
                        <span>AURA FLORIST</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- VALUES -->
    <section class="about-values">
        <div class="container">
            <div class="section-heading">
                <p class="section-label">ĐIỀU CHÚNG TÔI TIN</p>
                <h2>
                    Những giá trị tạo nên
                    <span>AURA FLORIST</span>
                </h2>
                <p>
                    Mỗi sản phẩm, mỗi dịch vụ đều bắt đầu từ sự quan tâm
                    dành cho khách hàng.
                </p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-number">01</div>
                    <div class="value-icon">✿</div>
                    <h3>Tươi mới</h3>
                    <p>
                        Chúng tôi ưu tiên những bông hoa tươi,
                        được lựa chọn kỹ càng để mỗi bó hoa luôn
                        giữ được vẻ đẹp tự nhiên.
                    </p>
                </div>
                <div class="value-card featured-value">
                    <div class="value-number">02</div>
                    <div class="value-icon">♡</div>
                    <h3>Tận tâm</h3>
                    <p>
                        Từ khâu tư vấn đến lúc hoàn thiện sản phẩm,
                        AURA luôn đặt cảm xúc và trải nghiệm của
                        khách hàng lên hàng đầu.
                    </p>
                </div>
                <div class="value-card">
                    <div class="value-number">03</div>
                    <div class="value-icon">✧</div>
                    <h3>Tinh tế</h3>
                    <p>
                        Mỗi thiết kế đều được chăm chút về màu sắc,
                        kiểu dáng và cách kết hợp để tạo nên
                        một món quà thật đặc biệt.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- NUMBERS -->
    <section class="about-numbers">
        <div class="container">
            <div class="numbers-grid">
                <div class="number-item">
                    <strong>500+</strong>
                    <span>Bó hoa đã trao</span>
                </div>
                <div class="number-item">
                    <strong>100%</strong>
                    <span>Tận tâm với khách hàng</span>
                </div>
                <div class="number-item">
                    <strong>24/7</strong>
                    <span>Sẵn sàng tư vấn</span>
                </div>
                <div class="number-item">
                    <strong>∞</strong>
                    <span>Câu chuyện yêu thương</span>
                </div>
            </div>
        </div>
    </section>
    <!-- CAM KẾT CỦA AURA FLORIST -->
    <section class="aura-commitment">
        <div class="container">
            <!-- TIÊU ĐỀ -->
            <div class="commitment-heading">
                <p class="commitment-label">
                    AURA FLORIST
                </p>
                <h2>CAM KẾT CỦA CHÚNG TÔI</h2>
                <div class="commitment-line">
                    <span></span>
                    <i class="bi bi-flower1"></i>
                    <span></span>
                </div>
                <p class="commitment-description">
                    Mỗi sản phẩm tại AURA FLORIST đều được chăm chút từ
                    khâu lựa chọn hoa đến khi trao tận tay người nhận.
                </p>
            </div>
            <!-- 4 CAM KẾT -->
            <div class="commitment-grid">
                <!-- CAM KẾT 01 -->
                <div class="commitment-item">
                    <span class="commitment-number">
                        01
                    </span>
                    <div class="commitment-icon">
                        <i class="bi bi-flower2"></i>
                    </div>
                    <div class="commitment-content">
                        <h3>Hoa tươi tuyển chọn</h3>
                        <p>
                            Hoa được lựa chọn kỹ lưỡng, ưu tiên độ tươi,
                            màu sắc hài hòa và chất lượng trước khi
                            thiết kế.
                        </p>
                    </div>
                </div>
                <!-- CAM KẾT 02 -->
                <div class="commitment-item">
                    <span class="commitment-number">
                        02
                    </span>
                    <div class="commitment-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <div class="commitment-content">
                        <h3>Giá cả minh bạch</h3>
                        <p>
                            Thông tin về giá sản phẩm và các khoản phí được cung cấp rõ ràng trước khi đặt hàng.
                        </p>
                    </div>
                </div>
                <!-- CAM KẾT 03 -->
                <div class="commitment-item">
                    <span class="commitment-number">
                        03
                    </span>
                    <div class="commitment-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="commitment-content">
                        <h3>Giao hoa cẩn thận</h3>
                        <p>
                            Sản phẩm được đóng gói và vận chuyển cẩn thận,
                            giúp hoa giữ được hình dáng và vẻ đẹp khi
                            đến tay người nhận.
                        </p>
                    </div>
                </div>
                <!-- CAM KẾT 04 -->
                <div class="commitment-item">
                    <span class="commitment-number">
                        04
                    </span>
                    <div class="commitment-icon">
                        <i class="bi bi-chat-heart"></i>
                    </div>
                    <div class="commitment-content">
                        <h3>Tận tâm với khách hàng</h3>
                        <p>
                            AURA FLORIST luôn lắng nghe nhu cầu và hỗ trợ
                            khách hàng lựa chọn sản phẩm phù hợp với
                            thông điệp muốn gửi trao.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA -->
    <section class="about-cta">
        <div class="container">
            <div class="cta-content">
                <p class="section-label">
                    AURA FLORIST
                </p>
                <h2>
                    Hãy để chúng tôi<br>
                    <span>cùng bạn tạo nên khoảnh khắc đẹp.</span>
                </h2>
                <a href="{{ route('products.index') }}" class="about-btn light-btn">
                    Chọn một bó hoa
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>
@endsection