<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // 12 sản phẩm nổi bật
        $featuredProducts = Product::with('reviews')
            ->whereIn('id', [
                1, 2, 3, 4,
                5, 6, 7, 8,
                25, 26, 27, 28
            ])
            ->orderByRaw(
                'FIELD(id, 1, 2, 3, 4, 5, 6, 7, 8, 25, 26, 27, 28)'
            )
            ->get();

        // 8 sản phẩm mới
        $newProducts = Product::with('reviews')
            ->whereIn('id', [
                9, 10, 11, 12,
                13, 14, 15, 16
            ])
            ->orderByRaw(
                'FIELD(id, 9, 10, 11, 12, 13, 14, 15, 16)'
            )
            ->get();

        // 8 sản phẩm bán chạy
        $bestSellers = Product::with('reviews')
            ->whereIn('id', [
                17, 18, 19, 20,
                21, 22, 23, 24
            ])
            ->orderByRaw(
                'FIELD(id, 17, 18, 19, 20, 21, 22, 23, 24)'
            )
            ->get();

        // Tổng số bình luận chung của tất cả hoa
        $globalReviewCount = Review::count();

        // Điểm đánh giá trung bình chung của tất cả hoa
        $globalAverageRating = Review::avg('rating') ?? 0;

        return view('home', compact(
            'featuredProducts',
            'newProducts',
            'bestSellers',
            'globalReviewCount',
            'globalAverageRating'
        ));
    }
}
