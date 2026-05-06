<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['customer_name', 'rating', 'message', 'feedback_date'];

    protected $casts = [
        'feedback_date' => 'date',
    ];
}
