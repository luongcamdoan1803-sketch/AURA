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
}
