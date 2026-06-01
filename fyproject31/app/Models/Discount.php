<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['name', 'percentage', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'percentage' => 'decimal:2',
        ];
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class);
    }
}
