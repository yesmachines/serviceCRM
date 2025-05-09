<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
     protected $fillable = [
        'user_id',
        'emp_num',
        'phone',
        'designation',
        'division',
        'image_url',
        'status',
    ];

    // Employee belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
