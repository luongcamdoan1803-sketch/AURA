<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'discount_percent',
        'rating',
        'style',
        'image',
        'description'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Giá sau khi giảm
    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_percent > 0) {
            return $this->price * (1 - $this->discount_percent / 100);
        }
        return (float) $this->price;
    }

    // Đường dẫn hình ảnh chuẩn (Khớp tuyệt đối với toàn bộ trang web và admin)
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/about-flower.jpg');
        }

        // Link ảnh online (http / https)
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Dữ liệu đã có tiền tố 'images/'
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        // Tên file lưu thông thường
        return asset('images/' . $this->image);
    }

    // Mô tả đã lọc sạch các thẻ HTML (<p>, </p>)
    public function getCleanDescriptionAttribute(): string
    {
        return trim(strip_tags($this->description ?? ''));
    }
}
