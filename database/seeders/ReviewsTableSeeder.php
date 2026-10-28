<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reviews')->delete();
        
        \DB::table('reviews')->insert(array (
            0 => 
            array (
                'id' => 25,
                'product_id' => 1,
                'user_id' => '2',
                'rating' => 5,
                'content' => 'Hoa bên ngoài rất tươi và đẹp, đóng gói chỉn chu, giao đúng hẹn!',
                'created_at' => '2026-10-14 16:33:28',
                'updated_at' => '2026-10-14 16:33:28',
            ),
            1 => 
            array (
                'id' => 26,
                'product_id' => 4,
                'user_id' => '5',
                'rating' => 5,
                'content' => 'Hoa tươi, shop tư vấn nhiệt tình và giao đúng hẹn',
                'created_at' => '2026-10-28 09:09:15',
                'updated_at' => '2026-10-28 09:09:15',
            ),
            2 => 
            array (
                'id' => 27,
                'product_id' => 9,
                'user_id' => '5',
                'rating' => 5,
                'content' => 'sẽ ủng hộ shop lần sau nhé',
                'created_at' => '2026-10-28 09:37:14',
                'updated_at' => '2026-10-28 09:37:14',
            ),
        ));
        
        
    }
}