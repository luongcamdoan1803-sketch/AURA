<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders')->delete();
        
        \DB::table('orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 2,
                'total_price' => '350000.00',
                'shipping_name' => 'Cẩm Đoan',
                'shipping_phone' => '0945339743',
                'shipping_address' => '123 Lê Lợi, Q.1, TP.HCM',
                'payment_method' => 'VietQR',
                'status' => 'pending',
                'created_at' => '2026-10-18 09:00:00',
                'updated_at' => '2026-10-18 09:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => 4,
                'total_price' => '520000.00',
                'shipping_name' => 'Lê Hoa',
                'shipping_phone' => '0913789537',
                'shipping_address' => '45 Nguyễn Trãi, Q.5, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'processing',
                'created_at' => '2026-10-18 09:15:00',
                'updated_at' => '2026-10-18 09:20:00',
            ),
            2 => 
            array (
                'id' => 3,
                'user_id' => 5,
                'total_price' => '180000.00',
                'shipping_name' => 'Thị Bình',
                'shipping_phone' => '678937435',
                'shipping_address' => '89 Điện Biên Phủ, Bình Thạnh, TP.HCM',
                'payment_method' => 'VietQR',
                'status' => 'shipping',
                'created_at' => '2026-10-18 09:30:00',
                'updated_at' => '2026-10-18 14:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'user_id' => 6,
                'total_price' => '750000.00',
                'shipping_name' => 'Văn B',
                'shipping_phone' => '0369745691',
                'shipping_address' => '12 Lạc Long Quân, Tân Bình, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'shipping',
                'created_at' => '2026-10-17 10:00:00',
                'updated_at' => '2026-10-18 08:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'user_id' => 7,
                'total_price' => '420000.00',
                'shipping_name' => 'Trần Hoàng',
                'shipping_phone' => '03697456345',
                'shipping_address' => '67 Võ Văn Ngân, Thủ Đức, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'pending',
                'created_at' => '2026-10-18 10:00:00',
                'updated_at' => '2026-10-18 10:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'user_id' => 8,
                'total_price' => '990000.00',
                'shipping_name' => 'Thị Chi',
                'shipping_phone' => '0569745691',
                'shipping_address' => '88 Hai Bà Trưng, Q.3, TP.HCM',
                'payment_method' => 'VietQR',
                'status' => 'processing',
                'created_at' => '2026-10-18 10:30:00',
                'updated_at' => '2026-10-18 10:30:00',
            ),
            6 => 
            array (
                'id' => 7,
                'user_id' => 9,
                'total_price' => '260000.00',
                'shipping_name' => 'Bảo Bình',
                'shipping_phone' => '0369435691',
                'shipping_address' => '102 Pasteur, Q.3, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'processing',
                'created_at' => '2026-10-16 11:00:00',
                'updated_at' => '2026-10-18 09:00:00',
            ),
            7 => 
            array (
                'id' => 8,
                'user_id' => 2,
                'total_price' => '680000.00',
                'shipping_name' => 'Cẩm Đoan',
                'shipping_phone' => '0945339743',
                'shipping_address' => '123 Lê Lợi, Q.1, TP.HCM',
                'payment_method' => 'VietQR',
                'status' => 'completed',
                'created_at' => '2026-10-15 15:00:00',
                'updated_at' => '2026-10-17 10:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'user_id' => 4,
                'total_price' => '310000.00',
                'shipping_name' => 'Lê Hoa',
                'shipping_phone' => '0913789537',
                'shipping_address' => '45 Nguyễn Trãi, Q.5, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'processing',
                'created_at' => '2026-10-18 11:00:00',
                'updated_at' => '2026-10-18 11:05:00',
            ),
            9 => 
            array (
                'id' => 10,
                'user_id' => 7,
                'total_price' => '1500000.00',
                'shipping_name' => 'Trần Hoàng',
                'shipping_phone' => '03697456345',
                'shipping_address' => '67 Võ Văn Ngân, Thủ Đức, TP.HCM',
                'payment_method' => 'COD',
                'status' => 'shipping',
                'created_at' => '2026-10-17 14:00:00',
                'updated_at' => '2026-10-18 09:30:00',
            ),
            10 => 
            array (
                'id' => 11,
                'user_id' => 5,
                'total_price' => '1102500.00',
                'shipping_name' => 'Thị Bình',
                'shipping_phone' => '0678937435',
                'shipping_address' => '140 Lê Trọng Tấn',
                'payment_method' => 'COD',
                'status' => 'pending',
                'created_at' => '2026-10-28 08:32:40',
                'updated_at' => '2026-10-28 08:32:40',
            ),
            11 => 
            array (
                'id' => 12,
                'user_id' => 5,
                'total_price' => '667500.00',
                'shipping_name' => 'Thị Bình',
                'shipping_phone' => '0678937435',
                'shipping_address' => '140 Lê Trọng Tấn',
                'payment_method' => 'VietQR',
                'status' => 'pending',
                'created_at' => '2026-10-28 08:34:02',
                'updated_at' => '2026-10-28 08:34:02',
            ),
        ));
        
        
    }
}