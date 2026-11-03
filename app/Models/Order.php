<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'city',
        'district',
        'ward',
        'to_district_id',
        'to_ward_code',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_status',
        'subtotal',
        'discount_amount',
        'voucher_code',
        'shipping_fee',
        'ghn_order_code',
        'ghn_total_fee',
        'shipping_distance',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'float',
        'discount_amount' => 'float',
        'shipping_fee' => 'float',
        'total_amount' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function latestPaymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class)->latestOfMany();
    }

    public function getTotalPriceAttribute(): float
    {
        return (float) ($this->total_amount ?? 0);
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', '.') . ' ₫';
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->order_status) {
            'pending' => ['label' => 'Chờ xác nhận', 'color' => 'bg-amber-100 text-amber-800 border-amber-300'],
            'processing' => ['label' => 'Đang chuẩn bị hàng', 'color' => 'bg-blue-100 text-blue-800 border-blue-300'],
            'shipping' => ['label' => 'Đang giao hàng', 'color' => 'bg-purple-100 text-purple-800 border-purple-300'],
            'completed' => ['label' => 'Giao thành công', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
            'cancelled' => ['label' => 'Đã hủy', 'color' => 'bg-rose-100 text-rose-800 border-rose-300'],
            default => ['label' => 'Đang xử lý', 'color' => 'bg-gray-100 text-gray-800 border-gray-300'],
        };
    }
}
