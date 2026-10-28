document.addEventListener('DOMContentLoaded', function () {

    const chatButton = document.getElementById('auraChatButton');
    const chatbox = document.getElementById('auraChatbox');
    const closeButton = document.getElementById('chatClose');

    const chatInput = document.getElementById('chatInput');
    const sendButton = document.getElementById('chatSend');

    const chatBody = document.getElementById('chatBody');

    const notification = document.querySelector('.chat-notification');


    /* =====================================================
       MỞ CHAT
       ===================================================== */

    chatButton.addEventListener('click', function () {

        chatbox.classList.toggle('show');

        if (notification) {
            notification.style.display = 'none';
        }

        if (chatbox.classList.contains('show')) {
            chatInput.focus();
        }

    });


    /* =====================================================
       ĐÓNG CHAT
       ===================================================== */

    closeButton.addEventListener('click', function () {

        chatbox.classList.remove('show');

    });


    /* =====================================================
       GỬI BẰNG NÚT
       ===================================================== */

    sendButton.addEventListener('click', function () {

        sendMessage();

    });


    /* =====================================================
       NHẤN ENTER ĐỂ GỬI
       ===================================================== */

    chatInput.addEventListener('keydown', function (event) {

        if (event.key === 'Enter') {

            event.preventDefault();

            sendMessage();

        }

    });


    /* =====================================================
       CÂU HỎI GỢI Ý
       ===================================================== */

    document.querySelectorAll('.quick-option').forEach(function (button) {

        button.addEventListener('click', function () {

            const message = this.getAttribute('data-message');

            addUserMessage(message);

            setTimeout(function () {

                const reply = getBotReply(message);

                addBotMessage(reply);

            }, 500);

        });

    });


    /* =====================================================
       GỬI TIN NHẮN
       ===================================================== */

    function sendMessage() {

        const message = chatInput.value.trim();

        if (message === '') {
            return;
        }


        addUserMessage(message);


        chatInput.value = '';


        setTimeout(function () {

            const reply = getBotReply(message);

            addBotMessage(reply);

        }, 500);

    }


    /* =====================================================
       HIỂN THỊ TIN NHẮN KHÁCH
       ===================================================== */

    function addUserMessage(message) {

        const messageBox = document.createElement('div');

        messageBox.className = 'chat-message user-message';


        const content = document.createElement('div');

        content.className = 'message-content';

        content.textContent = message;


        messageBox.appendChild(content);

        chatBody.appendChild(messageBox);


        scrollToBottom();

    }


    /* =====================================================
       HIỂN THỊ TIN NHẮN BOT
       ===================================================== */

    function addBotMessage(message) {

        const messageBox = document.createElement('div');

        messageBox.className = 'chat-message bot-message';


        const avatar = document.createElement('div');

        avatar.className = 'message-avatar';

        avatar.innerHTML = '<i class="bi bi-flower1"></i>';


        const content = document.createElement('div');

        content.className = 'message-content';

        content.textContent = message;


        messageBox.appendChild(avatar);

        messageBox.appendChild(content);

        chatBody.appendChild(messageBox);


        scrollToBottom();

    }


    /* =====================================================
       TỰ CUỘN XUỐNG
       ===================================================== */

    function scrollToBottom() {

        chatBody.scrollTop = chatBody.scrollHeight;

    }


    /* =====================================================
       XỬ LÝ CÂU TRẢ LỜI
       ===================================================== */

    function getBotReply(message) {

        const text = normalizeText(message);


        /* CHÀO HỎI */

        if (
            text.includes('xin chao') ||
            text === 'chao' ||
            text.includes('hello') ||
            text.includes('hi ')
        ) {

            return 'Xin chào 🌷 AURA FLORIST có thể giúp bạn tư vấn chọn hoa, tìm hiểu về giao hàng, thanh toán và đặt hàng.';

        }


        /* TƯ VẤN CHỌN HOA */

        if (
            text.includes('tu van') ||
            text.includes('chon hoa') ||
            text.includes('nen mua hoa')
        ) {

            return 'Bạn có thể chọn hoa theo dịp như sinh nhật, tình yêu, khai trương hoặc lễ cưới. Hãy cho mình biết bạn muốn tặng hoa vào dịp nào nhé!';

        }


        /* SINH NHẬT */

        if (
            text.includes('sinh nhat') ||
            text.includes('birthday')
        ) {

            return 'Với dịp sinh nhật, bạn có thể chọn bó hoa hoặc hộp hoa có màu sắc tươi sáng. AURA FLORIST có nhiều mẫu hoa sinh nhật phù hợp để tặng bạn bè, người yêu và người thân.';

        }


        /* TÌNH YÊU */

        if (
            text.includes('tinh yeu') ||
            text.includes('nguoi yeu') ||
            text.includes('ban gai') ||
            text.includes('ban trai') ||
            text.includes('valentine')
        ) {

            return 'Hoa hồng là lựa chọn phổ biến cho tình yêu ❤️ Ngoài ra bạn có thể chọn tulip hoặc các bó hoa có tông màu nhẹ nhàng để dành tặng người đặc biệt.';

        }


        /* KHAI TRƯƠNG */

        if (
            text.includes('khai truong') ||
            text.includes('chuc mung')
        ) {

            return 'Hoa khai trương thường ưu tiên những thiết kế nổi bật và mang ý nghĩa chúc mừng. Bạn có thể tham khảo các giỏ hoa hoặc thiết kế hoa chúc mừng của AURA FLORIST.';

        }


        /* HOA CƯỚI */

        if (
            text.includes('hoa cuoi') ||
            text.includes('dam cuoi') ||
            text.includes('le cuoi')
        ) {

            return 'AURA FLORIST có các thiết kế hoa phù hợp cho lễ cưới. Bạn có thể lựa chọn màu sắc và phong cách mong muốn để cửa hàng tư vấn mẫu phù hợp.';

        }


        /* BÓ HOA */

        if (text.includes('bo hoa')) {

            return 'Bó hoa phù hợp để tặng sinh nhật, người yêu, bạn bè hoặc trong những dịp đặc biệt. Bạn có thể vào mục Kiểu dáng → Bó hoa để xem sản phẩm.';

        }


        /* GIỎ HOA */

        if (text.includes('gio hoa')) {

            return 'Giỏ hoa là lựa chọn phù hợp cho các dịp chúc mừng, khai trương hoặc gửi tặng. Bạn có thể vào mục Kiểu dáng → Giỏ hoa để tham khảo.';

        }


        /* HỘP HOA */

        if (text.includes('hop hoa')) {

            return 'Hộp hoa có kiểu dáng gọn gàng và hiện đại, phù hợp làm quà tặng trong nhiều dịp. Bạn có thể vào mục Kiểu dáng → Hộp hoa để xem thêm.';

        }


        /* GIAO HÀNG */

        if (
            text.includes('giao hang') ||
            text.includes('giao hoa') ||
            text.includes('ship') ||
            text.includes('phi giao')
        ) {

            return 'AURA FLORIST có hỗ trợ giao hoa tận nơi 🚚 Phí giao hàng sẽ phụ thuộc vào khu vực và khoảng cách giao hàng.';

        }


        /* THANH TOÁN */

        if (
            text.includes('thanh toan') ||
            text.includes('chuyen khoan') ||
            text.includes('cod')
        ) {

            return 'Bạn có thể sử dụng các phương thức thanh toán mà cửa hàng hỗ trợ như thanh toán khi nhận hàng hoặc thanh toán điện tử theo thông tin hiển thị khi đặt hàng.';

        }


        /* ĐẶT HÀNG */

        if (
            text.includes('dat hang') ||
            text.includes('mua hoa') ||
            text.includes('dat hoa')
        ) {

            return 'Bạn hãy chọn sản phẩm yêu thích, thêm vào giỏ hàng và thực hiện các bước thanh toán để hoàn tất đơn hàng.';

        }


        /* GIÁ */

        if (
            text.includes('gia') ||
            text.includes('bao nhieu') ||
            text.includes('ngan sach')
        ) {

            return 'Giá hoa phụ thuộc vào loại hoa, kiểu dáng và kích thước sản phẩm. Bạn có thể xem giá trực tiếp tại trang Cửa hàng của AURA FLORIST.';

        }


        /* LIÊN HỆ */

        if (
            text.includes('lien he') ||
            text.includes('hotline') ||
            text.includes('so dien thoai') ||
            text.includes('email')
        ) {

            return 'Bạn có thể xem thông tin liên hệ của AURA FLORIST ở cuối trang hoặc truy cập trang Liên hệ để gửi lời nhắn cho cửa hàng.';

        }


        /* CẢM ƠN */

        if (
            text.includes('cam on') ||
            text.includes('thanks') ||
            text.includes('thank you')
        ) {

            return 'AURA FLORIST rất vui khi được hỗ trợ bạn 🌷 Chúc bạn chọn được một thiết kế hoa thật phù hợp!';

        }


        /* =====================================================
           KHÔNG HIỂU
           ===================================================== */

        return 'Mình chưa hiểu câu hỏi này. Bạn có thể hỏi mình về chọn hoa, hoa sinh nhật, hoa tình yêu, hoa khai trương, giao hàng, thanh toán hoặc cách đặt hàng nhé!';

    }


    /* =====================================================
       CHUYỂN TIẾNG VIỆT CÓ DẤU → KHÔNG DẤU
       ===================================================== */

    function normalizeText(text) {

        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd');

    }

});