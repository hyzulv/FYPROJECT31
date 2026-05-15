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

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
