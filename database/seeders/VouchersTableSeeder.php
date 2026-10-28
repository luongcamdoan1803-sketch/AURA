<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VouchersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vouchers')->delete();
        
        \DB::table('vouchers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'WELCOME',
                'discount_percent' => 10,
                'quantity' => 50,
                'created_at' => '2026-10-17 08:00:00',
                'updated_at' => '2026-10-17 08:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'FREESHIP',
                'discount_percent' => 10,
                'quantity' => 100,
                'created_at' => '2026-10-17 08:05:00',
                'updated_at' => '2026-10-17 08:05:00',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'BLACKFRIDAY',
                'discount_percent' => 40,
                'quantity' => 50,
                'created_at' => '2026-10-17 08:10:00',
                'updated_at' => '2026-10-17 08:10:00',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'VIPMEMBER',
                'discount_percent' => 15,
                'quantity' => 19,
                'created_at' => '2026-10-17 08:15:00',
                'updated_at' => '2026-10-28 08:34:02',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'SUMMER26',
                'discount_percent' => 20,
                'quantity' => 30,
                'created_at' => '2026-10-17 08:20:00',
                'updated_at' => '2026-10-17 08:20:00',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'FLASH5',
                'discount_percent' => 5,
                'quantity' => 20,
                'created_at' => '2026-10-17 08:25:00',
                'updated_at' => '2026-10-17 08:25:00',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'TEACHERDAY',
                'discount_percent' => 25,
                'quantity' => 30,
                'created_at' => '2026-10-17 08:30:00',
                'updated_at' => '2026-10-17 08:30:00',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'BIRTHDAY',
                'discount_percent' => 35,
                'quantity' => 39,
                'created_at' => '2026-10-17 08:35:00',
                'updated_at' => '2026-10-28 08:32:40',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'WEEKEND',
                'discount_percent' => 10,
                'quantity' => 60,
                'created_at' => '2026-10-17 08:40:00',
                'updated_at' => '2026-10-17 08:40:00',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'WOMENDAY',
                'discount_percent' => 30,
                'quantity' => 50,
                'created_at' => '2026-10-17 08:45:00',
                'updated_at' => '2026-10-17 08:45:00',
            ),
        ));
        
        
    }
}