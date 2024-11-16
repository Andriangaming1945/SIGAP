<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['glucose', 'bmi', 'age', 'blood_pressure', 'insulin', 'body_thickness', 'description'];
    
    public function diseaseDetail()
{
    return $this->belongsTo(DiseaseDetail::class, 'disease_id');
}
}


