<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartDiseasePrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'age', 'blood_pressure', 'cholesterol', 'heart_rate', 
        'smoking', 'diabetes', 'family_history', 'physical_inactivity', 
        'stress', 'obesity', 'cad', 'pitting_edema', 'anemia', 'chf',
        'risk_score', 'prediction', 'description'
    ];

    public function diseaseDetail()
{
    return $this->belongsTo(DiseaseDetail::class, 'disease_id');
}
}
