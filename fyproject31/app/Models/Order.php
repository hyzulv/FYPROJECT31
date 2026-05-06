<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_id', 'table_number', 'items', 'total', 'status', 'order_time'];

    protected $casts = [
        'total' => 'decimal:2',
        'order_time' => 'datetime:H:i',
    ];
}
