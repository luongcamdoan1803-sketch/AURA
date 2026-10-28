<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer' => 'Số sao không hợp lệ.',
            'rating.min' => 'Số sao tối thiểu là 1.',
            'rating.max' => 'Số sao tối đa là 5.',
            'content.required' => 'Vui lòng nhập nội dung bình luận.',
            'content.max' => 'Bình luận không được vượt quá 1000 ký tự.',
        ]);

        $product = Product::findOrFail($productId);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'content' => $data['content'],
            'rating' => $data['rating'],
        ]);

        return redirect()
            ->route('shop.detail', $product->id)
            ->with('success', 'Gửi bình luận thành công!');
    }
}
