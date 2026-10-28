<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'discount_percent',
        'quantity',
    ];

    /* Tìm voucher theo mã (không phân biệt hoa/thường) */
    public static function findByCode(string $code): ?self
    {
        return static::whereRaw('UPPER(code) = ?', [strtoupper(trim($code))])->first();
    }

    /* Còn lượt sử dụng hay không */
    public function isAvailable(): bool
    {
        return (int) $this->quantity > 0;
    }

    /* Số tiền được giảm trên một tạm tính */
    public function discountFor(int $subtotal): int
    {
        return (int) floor($subtotal * ((int) $this->discount_percent) / 100);
    }
}
