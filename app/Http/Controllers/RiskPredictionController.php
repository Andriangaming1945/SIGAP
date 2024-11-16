<?php

namespace App\Http\Controllers;

use App\Models\StrokePrediction;
use Illuminate\Http\Request;

class RiskPredictionController extends Controller
{
    public function index(Request $request)
    {
        $predictions = StrokePrediction::with('diseaseDetail')
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->get();

        return response()->json($predictions);
    }

    public function predicti(Request $request)
    {
        $validatedData = $request->validate([
            'age' => 'required|integer',
            'hypertension' => 'required|boolean',
            'heart_disease' => 'required|boolean',
            'avg_glucose_level' => 'required|numeric',
            'smoking_status' => 'required|boolean',
            'ac_near_face' => 'required|boolean',
            'head_injury' => 'required|boolean',
            'diabetes' => 'required|boolean',
            'obesity' => 'required|boolean',
            'less_exposure_to_sunlight' => 'required|boolean',
        ]);

        // Menghitung risk score dengan skala 0-100
        $riskScore = 0;

        // Faktor usia (0-20 poin)
        if ($validatedData['age'] > 65) {
            $riskScore += 20;
        } elseif ($validatedData['age'] > 50) {
            $riskScore += 15;
        } elseif ($validatedData['age'] > 40) {
            $riskScore += 10;
        }

        // Kondisi medis serius (0-40 poin)
        if ($validatedData['hypertension']) $riskScore += 15;
        if ($validatedData['heart_disease']) $riskScore += 15;
        if ($validatedData['diabetes']) $riskScore += 10;

        // Faktor gaya hidup dan kondisi tambahan (0-40 poin)
        if ($validatedData['avg_glucose_level'] > 126) {
            $riskScore += 10;
        } elseif ($validatedData['avg_glucose_level'] > 100) {
            $riskScore += 5;
        }

        if ($validatedData['smoking_status']) $riskScore += 10;
        if ($validatedData['obesity']) $riskScore += 5;
        if ($validatedData['ac_near_face']) $riskScore += 5;
        if ($validatedData['head_injury']) $riskScore += 5;
        if ($validatedData['less_exposure_to_sunlight']) $riskScore += 5;

        // Memastikan skor maksimal 100
        $riskScore = min($riskScore, 100);

        // Mengatur kategori prediksi berdasarkan skor risiko
        if ($riskScore >= 60) {
            $prediction = 'High Risk';
        } elseif ($riskScore >= 30) {
            $prediction = 'Medium Risk';
        } else {
            $prediction = 'Low Risk';
        }

        // Menyimpan hasil prediksi ke dalam database
        $predictionRecord = StrokePrediction::create(array_merge(
            $validatedData,
            ['risk_score' => $riskScore, 'prediction' => $prediction]
        ));

        return response()->json($predictionRecord);
    }
}
