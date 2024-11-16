<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiseaseDetail extends Model
{

    protected $table = 'disease_details';

    protected $fillable = ['name', 'status', 'description', 'risk_score'];

    public function heartDiseasePredictions()
    {
        return $this->hasMany(HeartDiseasePrediction::class, 'disease_id');
    }

    public function patientPredictions()
    {
        return $this->hasMany(Patient::class, 'disease_id');
    }

    public function strokePredictions()
    {
        return $this->hasMany(StrokePrediction::class, 'disease_id');
    }
}
