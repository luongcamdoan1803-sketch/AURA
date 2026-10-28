<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Các bảng độc lập (không chứa khóa ngoại)
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            VouchersTableSeeder::class,

            // 2. Các bảng phụ thuộc khóa ngoại từ bảng ở nhóm 1
            ProductsTableSeeder::class,      // Phụ thuộc vào category_id
            OrdersTableSeeder::class,        // Phụ thuộc vào user_id

            // 3. Các bảng phụ thuộc khóa ngoại từ bảng ở nhóm 2
            OrderDetailsTableSeeder::class,  // Phụ thuộc vào order_id & product_id
            ReviewsTableSeeder::class,       // Phụ thuộc vào product_id & user_id
        ]);
    }
}