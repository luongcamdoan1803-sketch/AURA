@extends('layouts.app')
@section('title', 'Câu hỏi thường gặp — AURA FLORIST')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush
@section('content')
<div class="faq-page">
    <div class="container">
        <!-- TIÊU ĐỀ TRANG -->
        <div class="faq-header">
            <div class="faq-decoration">
                <span></span>
                <i class="bi bi-question-circle"></i>
                <span></span>
            </div>
            <p class="faq-label">
                AURA SUPPORT
            </p>
            <h1>
                CÂU HỎI THƯỜNG GẶP
            </h1>
            <p class="faq-description">
                Một số câu hỏi phổ biến giúp bạn dễ dàng đặt hoa
                và sử dụng dịch vụ tại AURA FLORIST.
            </p>
        </div>
        <!-- DANH SÁCH CÂU HỎI -->
        <div class="faq-list">
            <!-- CÂU 1 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        AURA FLORIST có nhận đặt hoa theo yêu cầu không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Có. Bạn có thể yêu cầu thiết kế bó hoa, giỏ hoa
                    hoặc hộp hoa theo màu sắc, loại hoa, ngân sách
                    và dịp tặng.
                </div>
            </div>
            <!-- CÂU 2 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Tôi có thể đặt hoa trước bao lâu?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Bạn nên đặt hoa trước từ 1 đến 2 ngày để cửa hàng
                    có thời gian chuẩn bị hoa và hoàn thiện sản phẩm
                    một cách chỉn chu nhất.
                </div>
            </div>
            <!-- CÂU 3 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        AURA FLORIST có giao hoa tận nơi không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Có. AURA FLORIST hỗ trợ giao hoa tận nơi.
                    Phí giao hàng sẽ phụ thuộc vào khu vực và
                    khoảng cách giao hàng.
                </div>
            </div>
            <!-- CÂU 4 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Tôi có thể ghi lời nhắn kèm theo hoa không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Có. Bạn có thể gửi nội dung lời nhắn khi đặt hàng.
                    AURA FLORIST sẽ chuẩn bị thiệp và gửi kèm
                    cùng sản phẩm.
                </div>
            </div>
            <!-- CÂU 5 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Hoa thực tế có giống hoàn toàn với hình trên website không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Màu sắc hoặc một số loại hoa có thể thay đổi nhẹ
                    tùy theo mùa và nguồn hoa tại thời điểm đặt hàng.
                    Tuy nhiên, cửa hàng sẽ đảm bảo phong cách,
                    màu sắc chủ đạo và giá trị sản phẩm tương đương.
                </div>
            </div>
            <!-- CÂU 6 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Tôi có thể thay đổi thông tin đơn hàng sau khi đặt không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Có thể nếu đơn hàng chưa được xử lý hoặc chưa được
                    giao. Bạn nên liên hệ AURA FLORIST sớm nhất có thể
                    để được hỗ trợ thay đổi thông tin.
                </div>
            </div>
            <!-- CÂU 7 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        AURA FLORIST hỗ trợ những hình thức thanh toán nào?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Khách hàng có thể sử dụng các phương thức thanh toán
                    được cửa hàng hỗ trợ như thanh toán tiền mặt
                    hoặc chuyển khoản ngân hàng.
                </div>
            </div>
            <!-- CÂU 8 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Tôi có thể chọn loại hoa và màu sắc riêng không?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Có. Bạn có thể trao đổi với cửa hàng về loại hoa,
                    màu sắc và phong cách mong muốn. AURA FLORIST
                    sẽ tư vấn thiết kế phù hợp với nhu cầu của bạn.
                </div>
            </div>
            <!-- CÂU 9 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Làm sao để bảo quản hoa được tươi lâu hơn?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Bạn nên đặt hoa ở nơi thoáng mát, tránh ánh nắng
                    trực tiếp và nhiệt độ cao. Đối với hoa cắm bình,
                    nên thay nước thường xuyên và cắt bớt phần gốc
                    trước khi cắm lại.
                </div>
            </div>
            <!-- CÂU 10 -->
            <div class="faq-item">
                <button type="button" class="faq-question">
                    <span class="faq-question-text">
                        Làm sao để liên hệ với AURA FLORIST?
                    </span>
                    <span class="faq-icon">+</span>
                </button>
                <div class="faq-answer">
                    Bạn có thể liên hệ với AURA FLORIST qua hotline,
                    email hoặc gửi lời nhắn trực tiếp tại trang
                    Liên hệ trên website.
                </div>
            </div>
        </div>
    </div>
</div>
<!-- JAVASCRIPT ĐÓNG / MỞ CÂU TRẢ LỜI -->
<script>
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(function (question) {
        question.addEventListener('click', function () {
            const faqItem = this.closest('.faq-item');
            const icon = this.querySelector('.faq-icon');
            /* Đóng các câu hỏi khác */
            document.querySelectorAll('.faq-item').forEach(function (item) {
                if (item !== faqItem) {
                    item.classList.remove('active');
                    const otherIcon = item.querySelector('.faq-icon');
                    if (otherIcon) {
                        otherIcon.textContent = '+';
                    }
                }
            });
            /* Mở / đóng câu hiện tại */
            faqItem.classList.toggle('active');
            if (faqItem.classList.contains('active')) {
                icon.textContent = '−';
            } else {
                icon.textContent = '+';
            }
        });
    });
</script>
@endsection