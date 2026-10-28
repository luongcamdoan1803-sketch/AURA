<?php

/*
|--------------------------------------------------------------------------
| Cấu hình riêng của AURA FLORIST (giỏ hàng & thanh toán)
|--------------------------------------------------------------------------
*/

return [

    // Phí vận chuyển cố định cho mỗi đơn hàng (VNĐ)
    'shipping_fee' => 30000,

    // Số lượng tối đa của 1 sản phẩm trong giỏ
    'max_qty' => 99,

    // Thông tin chuyển khoản hiển thị ở trang "Đặt hàng thành công"
    'bank' => [
        'bank_name'      => 'Agribank - CN H. Bình Đại - Bến Tre',
        'account_name'   => 'TRAN NGOC BAO TRAN',
        'account_number' => '7104205387308',
        'qr_image'       => 'images/vietqr.png',
    ],
];
