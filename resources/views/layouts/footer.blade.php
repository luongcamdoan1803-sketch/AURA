<footer class="bg-section mt-5 pt-5 pb-3 border-top">
    <div class="container">
        <div class="row g-4">
            <!-- Thông tin shop -->
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold text-uppercase mb-3">AURA FLORIST</h5>
                <p class="text-muted small">
                    Chuyên cung cấp các loại hoa tươi nghệ thuật, hoa sự kiện, hoa cưới với phong cách hiện đại và tinh tế.
                </p>
                <p class="small mb-1"><i class="bi bi-geo-alt-fill text-danger"></i> 115 Lê Trọng Tấn, Phường Tân Sơn Nhì, Quận Tân Phú, TP.HCM</p>
                <p class="small mb-1"><i class="bi bi-telephone-fill"></i> Hotline: 0900 123 456</p>
                <p class="small"><i class="bi bi-envelope-fill"></i> Email: contact@auraflorist.com</p>
            </div>
            <!-- Điều khoản & Chính sách -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-uppercase mb-3">Thông tin</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-decoration-none text-secondary">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="{{ route('products.all') }}" class="text-decoration-none text-secondary">Danh mục sản phẩm</a></li>
                </ul>
            </div>
            <!-- Liên kết nhanh -->
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-uppercase mb-3">Hỗ trợ</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('faq') }}" class="text-decoration-none text-secondary">Câu hỏi thường gặp</a></li>
                    <li class="mb-2"><a href="{{ route('contact.index') }}" class="text-decoration-none text-secondary">Liên hệ</a></li>
                </ul>
            </div>
            <!-- Bản đồ cửa hàng -->
            <div class="col-lg-4 col-md-6">
                <h6 class="fw-bold text-uppercase mb-3">Vị Trí Cửa Hàng</h6>
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0729112123436!2d106.6264396735523!3d10.805727758655586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be29dc47505%3A0x89c7475083c140d6!2zMTE1IEzDqiBUcuG7jW5nIFThuqVuLCBUw6JuIFPGoW4gTmjDrCwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1789115279579!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>
        </div>
        <hr class="my-4 text-muted">
        <div class="text-center small text-muted">
            &copy; {{ date('Y') }} AURA FLORIST. Tất cả quyền được bảo lưu.
        </div>
    </div>
</footer>