<?php

namespace App\Http\Controllers;

use App\Models\Hipertensi;
use Illuminate\Http\Request;

class HypertensionPredictionController extends Controller
{
    public function pre(Request $request)
    {
        $validatedData = $request->validate([
            'nyeri_dada' => 'required|boolean',
            'sesak_nafas' => 'required|boolean',
            'pusing' => 'required|boolean',
            'mual' => 'required|boolean',
            'kelelahan' => 'required|boolean',
            'tekanan_darah_tinggi' => 'required|boolean',
            'riwayat_hipertensi' => 'required|boolean',
        ]);

        $riskScore = 0;
        $symptomCount = 0; // Count the number of selected symptoms

        // Main symptom factors (0-50 points)
        if ($validatedData['nyeri_dada']) { $riskScore += 15; $symptomCount++; }
        if ($validatedData['sesak_nafas']) { $riskScore += 10; $symptomCount++; }
        if ($validatedData['pusing']) { $riskScore += 10; $symptomCount++; }

        // Serious symptom factors (0-30 points)
        if ($validatedData['mual']) { $riskScore += 10; $symptomCount++; }
        if ($validatedData['kelelahan']) { $riskScore += 10; $symptomCount++; }

        // Blood pressure and history factors (0-20 points)
        if ($validatedData['tekanan_darah_tinggi']) { $riskScore += 15; $symptomCount++; }
        if ($validatedData['riwayat_hipertensi']) { $riskScore += 5; $symptomCount++; }

        // Ensure the maximum score is 100
        $riskScore = min($riskScore, 100);

        // Improved prediction logic
        if ($riskScore < 33) {
            $prediction = 'Low Risk';
        } elseif ($riskScore >= 33 && $riskScore <= 66) {
            $prediction = 'Medium Risk';
        } else {
            $prediction = 'High Risk';
        }

        // Adjust risk score based on prediction category
        if ($prediction == 'Low Risk') {
            $riskScore = rand(1, 32);  // Risk range 1% - 32% for Low Risk
        } elseif ($prediction == 'Medium Risk') {
            $riskScore = rand(33, 66); // Risk range 33% - 66% for Medium Risk
        } else {
            $riskScore = rand(67, 100); // Risk range 67% - 100% for High Risk
        }

        // Save prediction result to the database
        $predictionRecord = Hipertensi::create(array_merge(
            $validatedData,
            ['risk_score' => $riskScore, 'prediction' => $prediction]
        ));

        // Return the response in the desired format
        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'hypertension' => $validatedData,
            'created_at' => $predictionRecord->created_at->toISOString(),
            'updated_at' => $predictionRecord->updated_at->toISOString(),
            'id' => $predictionRecord->id,
            'prediction' => $prediction,
            'risk_score' => $riskScore,
        ]);
    }
}
