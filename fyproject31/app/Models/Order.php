<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'table_number', 'items', 'total', 'status', 'order_time', 'payment_status', 'bill_code', 'transaction_id', 'paid_at'];

    protected $casts = [
        'total' => 'decimal:2',
        'order_time' => 'datetime:H:i',
        'paid_at' => 'datetime',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getItemsArrayAttribute()
    {
        return json_decode($this->items, true) ?? [];
    }
}
