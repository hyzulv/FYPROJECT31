<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
