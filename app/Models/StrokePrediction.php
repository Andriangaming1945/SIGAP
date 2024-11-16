<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrokePrediction extends Model
{
    protected $fillable = [
        'age',
        'hypertension',
        'heart_disease',
        'avg_glucose_level',
        'smoking_status',
        'ac_near_face',
        'head_injury',
        'diabetes',
        'obesity',
        'less_exposure_to_sunlight',
        'risk_score',
        'prediction'
    ];

    public function diseaseDetail()
{
    return $this->belongsTo(DiseaseDetail::class, 'disease_id');
}
}






