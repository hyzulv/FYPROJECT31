<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category', 'status', 'image', 'applies_to', 'exclude_for', 'group_name', 'selection_type'];

    protected $casts = [
        'price' => 'decimal:2',
        'applies_to' => 'array',
        'exclude_for' => 'array',
    ];

    protected $appends = ['effective_price'];

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    public function activeDiscounts()
    {
        return $this->belongsToMany(Discount::class)->where('is_active', true);
    }

    public function getEffectivePriceAttribute()
    {
        $maxDiscount = $this->activeDiscounts->max('percentage') ?? 0;
        if ($maxDiscount <= 0) {
            return $this->price;
        }
        return round($this->price * (1 - $maxDiscount / 100), 2);
    }

    public function getDiscountPercentageAttribute()
    {
        return $this->activeDiscounts->max('percentage') ?? 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
