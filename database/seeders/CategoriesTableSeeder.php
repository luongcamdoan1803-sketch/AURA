<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Hoa tình yêu',
                'slug' => 'hoa-tinh-yeu',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Hoa sinh nhật',
                'slug' => 'hoa-sinh-nhat',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Hoa chúc mừng',
                'slug' => 'hoa-chuc-mung',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Hoa khai trương',
                'slug' => 'hoa-khai-truong',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Hoa cưới',
                'slug' => 'hoa-cuoi',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Hoa theo mùa',
                'slug' => 'hoa-theo-mua',
                'type' => 'kieu_dang',
                'created_at' => '2026-10-01 05:47:26',
                'updated_at' => '2026-10-01 05:47:26',
            ),
        ));
        
        
    }
}