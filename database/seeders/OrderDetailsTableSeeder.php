<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('order_details')->delete();
        
        \DB::table('order_details')->insert(array (
            0 => 
            array (
                'id' => 1,
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'price' => '350000.00',
                'created_at' => '2026-10-18 09:00:00',
                'updated_at' => '2026-10-18 09:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'price' => '520000.00',
                'created_at' => '2026-10-18 09:15:00',
                'updated_at' => '2026-10-18 09:15:00',
            ),
            2 => 
            array (
                'id' => 3,
                'order_id' => 3,
                'product_id' => 3,
                'quantity' => 1,
                'price' => '180000.00',
                'created_at' => '2026-10-18 09:30:00',
                'updated_at' => '2026-10-18 09:30:00',
            ),
            3 => 
            array (
                'id' => 4,
                'order_id' => 4,
                'product_id' => 4,
                'quantity' => 1,
                'price' => '750000.00',
                'created_at' => '2026-10-17 10:00:00',
                'updated_at' => '2026-10-17 10:00:00',
            ),
            4 => 
            array (
                'id' => 5,
                'order_id' => 5,
                'product_id' => 5,
                'quantity' => 1,
                'price' => '420000.00',
                'created_at' => '2026-10-18 10:00:00',
                'updated_at' => '2026-10-18 10:00:00',
            ),
            5 => 
            array (
                'id' => 6,
                'order_id' => 6,
                'product_id' => 1,
                'quantity' => 1,
                'price' => '450000.00',
                'created_at' => '2026-10-18 10:30:00',
                'updated_at' => '2026-10-18 10:30:00',
            ),
            6 => 
            array (
                'id' => 7,
                'order_id' => 7,
                'product_id' => 2,
                'quantity' => 1,
                'price' => '540000.00',
                'created_at' => '2026-10-18 10:30:00',
                'updated_at' => '2026-10-18 10:30:00',
            ),
            7 => 
            array (
                'id' => 8,
                'order_id' => 8,
                'product_id' => 3,
                'quantity' => 1,
                'price' => '260000.00',
                'created_at' => '2026-10-16 11:00:00',
                'updated_at' => '2026-10-16 11:00:00',
            ),
            8 => 
            array (
                'id' => 9,
                'order_id' => 9,
                'product_id' => 4,
                'quantity' => 1,
                'price' => '680000.00',
                'created_at' => '2026-10-15 15:00:00',
                'updated_at' => '2026-10-15 15:00:00',
            ),
            9 => 
            array (
                'id' => 10,
                'order_id' => 10,
                'product_id' => 5,
                'quantity' => 1,
                'price' => '310000.00',
                'created_at' => '2026-10-18 11:00:00',
                'updated_at' => '2026-10-18 11:00:00',
            ),
            10 => 
            array (
                'id' => 11,
                'order_id' => 11,
                'product_id' => 2,
                'quantity' => 3,
                'price' => '550000.00',
                'created_at' => '2026-10-28 08:32:40',
                'updated_at' => '2026-10-28 08:32:40',
            ),
            11 => 
            array (
                'id' => 12,
                'order_id' => 12,
                'product_id' => 39,
                'quantity' => 1,
                'price' => '750000.00',
                'created_at' => '2026-10-28 08:34:02',
                'updated_at' => '2026-10-28 08:34:02',
            ),
        ));
        
        
    }
}