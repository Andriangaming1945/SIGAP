<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets'; 

    protected $fillable = [
        'name',  
        'email', 
        'code',  
    ];

    public function diseaseDetail()
    {
        return $this->belongsTo(DiseaseDetail::class, 'disease_id');
    }

    public $timestamps = true; 
}
