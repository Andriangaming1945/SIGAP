<?php

namespace App\Http\Controllers;

use App\Models\HeartDiseasePrediction;
use Illuminate\Http\Request;

class HeartDiseasePredictionController extends Controller
{
    public function prediction(Request $request)
{
    $validatedData = $request->validate([
        'age' => 'required|integer',
        'blood_pressure' => 'required|integer',
        'cholesterol' => 'required|integer',
        'heart_rate' => 'required|integer',
        'smoking' => 'required|boolean',
        'diabetes' => 'required|boolean',
        'family_history' => 'required|boolean',
        'physical_inactivity' => 'required|boolean',
        'stress' => 'required|boolean',
        'obesity' => 'required|boolean',
        'cad' => 'required|boolean',
        'pitting_edema' => 'required|boolean',
        'anemia' => 'required|boolean',
        'chf' => 'required|boolean',
    ]);
    
    $riskScore = 0;
    
    // Faktor utama (0-40 poin)
    // Usia
    if ($validatedData['age'] > 65) {
        $riskScore += 15;
    } elseif ($validatedData['age'] > 50) {
        $riskScore += 10;
    } elseif ($validatedData['age'] > 40) {
        $riskScore += 5;
    }

    // Tekanan darah
    if ($validatedData['blood_pressure'] > 160) {
        $riskScore += 15;
    } elseif ($validatedData['blood_pressure'] > 140) {
        $riskScore += 10;
    } elseif ($validatedData['blood_pressure'] > 120) {
        $riskScore += 5;
    }

    // Kolesterol
    if ($validatedData['cholesterol'] > 240) {
        $riskScore += 10;
    } elseif ($validatedData['cholesterol'] > 200) {
        $riskScore += 5;
    }

    // Faktor risiko serius (0-30 poin)
    if ($validatedData['cad']) $riskScore += 10;
    if ($validatedData['chf']) $riskScore += 10;
    if ($validatedData['diabetes']) $riskScore += 10;

    // Faktor gaya hidup (0-20 poin)
    if ($validatedData['smoking']) $riskScore += 5;
    if ($validatedData['physical_inactivity']) $riskScore += 5;
    if ($validatedData['obesity']) $riskScore += 5;
    if ($validatedData['stress']) $riskScore += 5;

    // Faktor tambahan (0-10 poin)
    if ($validatedData['family_history']) $riskScore += 3;
    if ($validatedData['pitting_edema']) $riskScore += 4;
    if ($validatedData['anemia']) $riskScore += 3;

    // Heart rate
    if ($validatedData['heart_rate'] > 100) {
        $riskScore += 5;
    }

    // Memastikan skor maksimal 100
    $riskScore = min($riskScore, 100);
    
    $prediction = $riskScore >= 50 ? 'High Risk' : 'Low Risk';
    
    $predictionRecord = HeartDiseasePrediction::create(array_merge(
        $validatedData,
        ['risk_score' => $riskScore, 'prediction' => $prediction]
    ));
   
    return response()->json($predictionRecord);
}

    public function index(Request $request)
    {
        $predictions = HeartDiseasePrediction::with('diseaseDetail')
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->get();

        return response()->json($predictions);
    }
}
