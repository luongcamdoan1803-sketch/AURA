<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'payment_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    /* Mã đơn hàng hiển thị, ví dụ: #AF2026015 */
    public function getCodeAttribute(): string
    {
        $year = $this->created_at ? $this->created_at->format('Y') : date('Y');

        return 'AF' . $year . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function getPaymentLabelAttribute(): string
    {
        return $this->payment_method === 'COD'
            ? 'Thanh toán khi nhận hàng (COD)'
            : 'Chuyển khoản ngân hàng (VietQR)';
    }

    public function getIsTransferAttribute(): bool
    {
        return $this->payment_method !== 'COD';
    }

    /* Nhãn trạng thái đơn hàng */
    public function getStatusLabelAttribute(): string
    {
        if ($this->status === 'pending') {
            return $this->is_transfer ? 'Chờ thanh toán' : 'Chờ xác nhận';
        }

        return [
            'processing' => 'Đang xử lý',
            'shipping'   => 'Đang giao hàng',
            'completed'  => 'Đã hoàn thành',
        ][$this->status] ?? $this->status;
    }

    /* Class màu cho nhãn trạng thái (định nghĩa trong cart.css) */
    public function getStatusClassAttribute(): string
    {
        return 'status-' . $this->status;
    }
}
