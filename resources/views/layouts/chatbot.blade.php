<!-- AURA FLORIST CHATBOT -->
<!-- Nút mở chatbot -->
<button type="button" class="aura-chat-button" id="auraChatButton">
    <i class="bi bi-chat-dots-fill"></i>
</button>
<!-- Khung chatbot -->
<div class="aura-chatbox" id="auraChatbox">
    <!-- HEADER -->
    <div class="aura-chat-header">
        <div class="chat-header-info">
            <div class="chat-avatar">
                <i class="bi bi-flower1"></i>
            </div>
            <div>
                <h5>AURA Assistant</h5>
                <p>
                    <span class="online-dot"></span>
                    Đang trực tuyến
                </p>
            </div>
        </div>
        <button type="button"
                class="chat-close"
                id="chatClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    <!-- NỘI DUNG CHAT -->
    <div class="aura-chat-body" id="chatBody">
        <!-- Tin nhắn mặc định -->
        <div class="chat-message bot-message">
            <div class="message-avatar">
                <i class="bi bi-flower1"></i>
            </div>
            <div class="message-content">
                Xin chào! 🌷<br>
                Mình là trợ lý của AURA FLORIST.
                Mình có thể giúp bạn tìm hiểu về hoa,
                đặt hàng và dịch vụ của cửa hàng.
            </div>
        </div>
        <!-- GỢI Ý NHANH -->
        <div class="quick-title">
            Bạn cần hỗ trợ gì?
        </div>
        <div class="quick-options">
            <button type="button"
                    class="quick-option"
                    data-message="Tư vấn chọn hoa">
                🌷 Tư vấn chọn hoa
            </button>
            <button type="button"
                    class="quick-option"
                    data-message="Hoa sinh nhật">
                🎂 Hoa sinh nhật
            </button>
            <button type="button"
                    class="quick-option"
                    data-message="Hoa tình yêu">
                ❤️ Hoa tình yêu
            </button>
            <button type="button"
                    class="quick-option"
                    data-message="Hoa khai trương">
                🎉 Hoa khai trương
            </button>
            <button type="button"
                    class="quick-option"
                    data-message="Phí giao hàng">
                🚚 Phí giao hàng
            </button>
            <button type="button"
                    class="quick-option"
                    data-message="Thanh toán">
                💳 Thanh toán
            </button>
        </div>
    </div>
    <!-- KHU VỰC NHẬP -->
    <div class="aura-chat-input">
        <input
            type="text"
            id="chatInput"
            placeholder="Nhập câu hỏi của bạn..."
            autocomplete="off"
        >
        <button type="button" id="chatSend">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>
</div>