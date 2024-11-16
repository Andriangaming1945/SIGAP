<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiseaseHistory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'description',
        'year'
    ];

    protected $casts = [
        'year' => 'integer'
    ];
}
