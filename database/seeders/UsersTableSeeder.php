<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array(
            0 =>
                array(
                    'id' => 2,
                    'name' => 'Cẩm Đoan',
                    'email' => 'luongcamdoan1803@gmail.com',
                    'password' => '$2y$10$PDD1fL/ohmC8A8HvWx0YzeOtzFUS.7ySYHp3i8067Cg3geHR6z0ry',
                    'phone' => '0945339743',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-09-11 01:05:23',
                    'updated_at' => '2026-09-17 22:13:30',
                ),
            1 =>
                array(
                    'id' => 3,
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'password' => '$2y$10$ipWs3gQdAwEfuwKUzvEsxOCwDXMa.GC0uwAzFpBrUGVQmrm8oUyE6',
                    'phone' => NULL,
                    'address' => NULL,
                    'role' => 1,
                    'created_at' => '2026-09-11 07:14:04',
                    'updated_at' => '2026-09-11 07:14:04',
                ),
            2 =>
                array(
                    'id' => 4,
                    'name' => 'Lê Hoa',
                    'email' => 'hoa@gmail.com',
                    'password' => '$2y$10$o0ALym3in6IWKn4caLTnTurlcH2e7C.Wn6BHLB3B6QhOuC4nJ6umm',
                    'phone' => '0913789537',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:24:47',
                    'updated_at' => '2026-10-14 19:24:47',
                ),
            3 =>
                array(
                    'id' => 5,
                    'name' => 'Thị Bình',
                    'email' => 'binh@gmail.com',
                    'password' => '$2y$10$V4poRpMoCnDCO8ztStRcfu7D4Rs8xS2HD9TwsV0DnydrrGMYuYalG',
                    'phone' => '678937435',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:25:41',
                    'updated_at' => '2026-10-14 19:25:41',
                ),
            4 =>
                array(
                    'id' => 6,
                    'name' => 'Văn B',
                    'email' => 'b@gmail.com',
                    'password' => '$2y$10$aSxMFZXwOPzdv16SWMRjD.8WV5.D0yvowzKWo7rq5CY8HCjwHxLbO',
                    'phone' => '0369745691',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:29:52',
                    'updated_at' => '2026-10-14 19:29:52',
                ),
            5 =>
                array(
                    'id' => 7,
                    'name' => 'Trần Hoàng',
                    'email' => 'hoang@gmail.com',
                    'password' => '$2y$10$VabQc.o0SPZh/PTTdiXMneBNn4cUl3jfbVyfAlP8.TV6HNeOPWyMK',
                    'phone' => '03697456345',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:30:51',
                    'updated_at' => '2026-10-14 19:30:51',
                ),
            6 =>
                array(
                    'id' => 8,
                    'name' => 'Thị Chi',
                    'email' => 'chi@gmail.com',
                    'password' => '$2y$10$Ej79vkcpxh6y7a4QxXbUJuVDomL43WUPE3s/8aXsJV10vRXWBzmWm',
                    'phone' => '0569745691',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:32:50',
                    'updated_at' => '2026-10-14 19:32:50',
                ),
            7 =>
                array(
                    'id' => 9,
                    'name' => 'Bảo Bình',
                    'email' => 'binhbao@mail.com',
                    'password' => '$2y$10$pCla/G3IkQxDJ50udm4ReuUBaUHuNZsA9DPDRIKr0bZ1tVBsskL5G',
                    'phone' => '0369435691',
                    'address' => NULL,
                    'role' => 0,
                    'created_at' => '2026-10-14 19:33:57',
                    'updated_at' => '2026-10-14 19:33:57',
                ),
        ));


    }
}