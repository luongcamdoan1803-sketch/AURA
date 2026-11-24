<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'content',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tự động đồng bộ số sao khi thêm hoặc sửa đánh giá
    protected static function booted()
    {
        static::saved(function ($review) {
            self::updateProductRating($review->product_id);
        });

        // Tự động đồng bộ số sao khi xóa đánh giá
        static::deleted(function ($review) {
            self::updateProductRating($review->product_id);
        });
    }

    // Tính lại điểm trung bình của từng sản phẩm
    protected static function updateProductRating($productId)
    {
        $averageRating = self::where('product_id', $productId)
            ->avg('rating') ?? 0;

        Product::where('id', $productId)->update([
            'rating' => round($averageRating, 1)
        ]);
    }
}