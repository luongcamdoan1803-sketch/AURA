<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    public function run()
    {
        // Xóa đánh giá cũ
        DB::table('reviews')->delete();

        // Lấy danh sách sản phẩm
        $products = DB::table('products')->get();

        // Chỉ lấy tài khoản khách hàng, không lấy Admin
        $users = DB::table('users')
            ->where('role', 0)
            ->pluck('id')
            ->toArray();

        if (empty($users)) {
            throw new \Exception('Không tìm thấy tài khoản khách hàng để tạo đánh giá.');
        }

        // Nội dung đánh giá ngẫu nhiên
        $comments = [
            'Hoa tươi hơn mong đợi, màu sắc rất đẹp và được gói vô cùng cẩn thận.',
            'Sản phẩm đẹp, hoa còn tươi và không bị dập khi giao đến.',
            'Mình rất hài lòng với chất lượng hoa, thiết kế tinh tế và sang trọng.',
            'Hoa được cắm rất đẹp, màu sắc hài hòa, nhìn bên ngoài còn đẹp hơn hình.',
            'Shop chuẩn bị đơn hàng rất chỉn chu, hoa tươi và giao hàng đúng hẹn.',
            'Mình đặt làm quà tặng và người nhận rất thích. Chắc chắn sẽ quay lại.',
            'Hoa đẹp, cách phối màu rất tinh tế, phù hợp để làm quà tặng.',
            'Đóng gói cẩn thận, hoa giữ được độ tươi và hình dáng rất đẹp.',
            'Chất lượng sản phẩm tốt, hoa tươi và thiết kế đúng như mong đợi.',
            'Mình rất thích cách shop lựa chọn và phối các loại hoa.',
            'Sản phẩm đẹp mắt, sang trọng, rất phù hợp với dịp đặc biệt.',
            'Hoa được giao nguyên vẹn, không bị hư hỏng. Rất đáng tiền.',
            'Shop tư vấn nhiệt tình, sản phẩm đẹp và chất lượng rất tốt.',
            'Màu hoa ngoài đời rất xinh, cách trang trí cũng vô cùng tinh tế.',
            'Đây là lần thứ hai mình đặt hoa tại shop và vẫn rất hài lòng.',
            'Hoa tươi, cánh hoa đẹp, cách gói quà cũng rất chuyên nghiệp.',
            'Sản phẩm giống hình, hoa được sắp xếp đẹp và rất có thẩm mỹ.',
            'Mình đã nhận được hoa và rất ưng ý. Cảm ơn shop nhiều nhé!',
            'Thiết kế đẹp, hoa tươi lâu và có mùi hương rất dễ chịu.',
            'Rất hài lòng với đơn hàng, từ chất lượng hoa đến cách phục vụ.',
            'Hoa khá đẹp nhưng một vài bông chưa được tươi như mong đợi.',
            'Sản phẩm ổn, tuy nhiên màu sắc thực tế hơi khác hình một chút.',
            'Hoa đẹp nhưng thời gian giao hàng hơi lâu.',
            'Cách gói hoa đẹp, nhưng mình mong shop có thể chăm chút phần cắm hoa hơn.'
        ];

        // Phần lớn 5 sao, một số 4 sao và điểm trung gian
        $ratings = [
            4, 4,
            4.5,
            4.8,
            4.9,
            5, 5, 5, 5, 5
        ];

        $reviews = [];

        foreach ($products as $product) {

            // Mỗi sản phẩm có ngẫu nhiên từ 4 đến 8 đánh giá
            $numberOfReviews = rand(4, 8);

            for ($i = 0; $i < $numberOfReviews; $i++) {
                $rating = $ratings[array_rand($ratings)];

                // Chọn bình luận phù hợp với số sao
                if ($rating <= 4.5) {
                    $comment = $comments[array_rand(array_slice($comments, 20, 4)) + 20];
                } else {
                    $comment = $comments[array_rand(array_slice($comments, 0, 20))];
                }

                $reviews[] = [
                    'product_id' => $product->id,
                    'user_id' => $users[array_rand($users)],
                    'rating' => $rating,
                    'content' => $comment,
                    'created_at' => now()->subDays(rand(1, 60)),
                    'updated_at' => now(),
                ];
            }
        }

        // Thêm toàn bộ đánh giá vào database
        DB::table('reviews')->insert($reviews);
    }
}
