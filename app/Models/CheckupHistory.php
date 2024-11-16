<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupHistory extends Model
{
    protected $fillable = [
        'user_id',
        'doctor',
        'hospital',
        'date',
        'year'
    ];

    protected $casts = [
        'date' => 'datetime',
        'year' => 'integer'
    ];
}
