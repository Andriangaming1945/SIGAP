<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class DiabetesPredictionController extends Controller
{

    public function index(Request $request)
    {
        $predictions = Patient::with('diseaseDetail')
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->get();

        return response()->json($predictions);
    }

    public function predict(Request $request)
    {
        $request->validate([
            'glucose' => 'required|numeric',
            'bmi' => 'required|numeric',
            'age' => 'required|integer',
            'blood_pressure' => 'required|numeric',
            'insulin' => 'required|numeric',
            'body_thickness' => 'required|numeric',
        ]);

        $patient = new Patient();
        $patient->glucose = number_format($request->input('glucose'), 2, '.', '');
        $patient->bmi = number_format($request->input('bmi'), 2, '.', '');
        $patient->age = $request->input('age');
        $patient->blood_pressure = number_format($request->input('blood_pressure'), 2, '.', '');
        $patient->insulin = number_format($request->input('insulin'), 2, '.', '');
        $patient->body_thickness = number_format($request->input('body_thickness'), 2, '.', '');

        // Calculate risk score and prediction
        $risk_score = $this->calculateRiskScore(
            $patient->glucose,
            $patient->bmi,
            $patient->age,
            $patient->blood_pressure,
            $patient->insulin,
            $patient->body_thickness
        );
        $prediction = $this->getPrediction($risk_score);

        $patient->risk_score = $risk_score;
        $patient->prediction = $prediction;
        $patient->save();

        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'patient' => $patient,
            'prediction' => $prediction,
            'risk_score' => $risk_score,
        ]);
    }

    private function calculateRiskScore($glucose, $bmi, $age, $blood_pressure, $insulin, $body_thickness)
    {
        $score = 0;

        // Skor untuk glukosa (jika di atas 140, risiko tinggi)
        if ($glucose > 140) {
            $score += 40;
        } elseif ($glucose >= 100) {
            $score += 20;
        }

        // Skor untuk BMI (jika di atas 30, risiko tinggi)
        if ($bmi > 30) {
            $score += 30;
        } elseif ($bmi >= 25) {
            $score += 20;
        }

        // Skor untuk usia (semakin tua, semakin tinggi risiko)
        if ($age > 50) {
            $score += 20;
        } elseif ($age >= 30) {
            $score += 10;
        }

        // Skor untuk tekanan darah (jika di atas 140, risiko tinggi)
        if ($blood_pressure > 140) {
            $score += 30;
        } elseif ($blood_pressure >= 120) {
            $score += 15;
        }

        // Skor untuk insulin (jika di atas 25, risiko tinggi)
        if ($insulin > 25) {
            $score += 20;
        } elseif ($insulin >= 10) {
            $score += 10;
        }

        // Skor untuk ketebalan tubuh (jika di atas 25 mm, risiko tinggi)
        if ($body_thickness > 25) {
            $score += 20;
        } elseif ($body_thickness >= 15) {
            $score += 10;
        }

        // Skor maksimal 100
        $score = min($score, 100);

        return $score;
    }

    private function getPrediction($risk_score)
    {
        if ($risk_score >= 50) {
            return 'High risk';
        } elseif ($risk_score >= 30) {
            return 'Medium low risk';
        } else {
            return 'Low risk';
        }
    }
}
