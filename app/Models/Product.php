<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sku',
        'brand',
        'gender',
        'price',
        'original_price',
        'stock',
        'movement',
        'dial_size',
        'case_material',
        'strap_material',
        'water_resistance',
        'glass_type',
        'power_reserve',
        'warranty_years',
        'origin',
        'image',
        'gallery',
        'short_description',
        'description',
        'is_featured',
        'is_best_seller',
        'is_new',
        'rating',
        'reviews_count',
        'sold_count',
    ];

    protected $casts = [
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new' => 'boolean',
        'rating' => 'float',
        'price' => 'float',
        'original_price' => 'float',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return null;
        }
        return number_format($this->original_price, 0, ',', '.') . ' ₫';
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->original_price || $this->original_price <= $this->price) {
            return 0;
        }
        return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'men' => 'Đồng hồ Nam',
            'women' => 'Đồng hồ Nữ',
            'unisex' => 'Unisex Nam & Nữ',
            default => 'Đồng hồ Nam'
        };
    }
}
