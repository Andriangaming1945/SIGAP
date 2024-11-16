<?php

namespace App\Http\Controllers;

use App\Models\LeukemiaPrediction;
use App\Models\Leukimia;
use Illuminate\Http\Request;

class LeukemiaPredictionController extends Controller
{
    public function prediksi(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pasien' => 'required|string|max:255',  
            'sel_darah_putih' => 'required|integer',
            'hemoglobin' => 'required|decimal:2',
            'trombosit' => 'required|integer',
            'asam_urat' => 'required|decimal:2',
            'ldh' => 'required|decimal:2',
        ]);

        $riskScore = 0;
        $symptomCount = 0; // Menghitung jumlah faktor yang diperhitungkan

        // Faktor utama (0-50 poin)
        if ($validatedData['sel_darah_putih'] < 4000) { 
            $riskScore += 15; 
            $symptomCount++;
        }
        if ($validatedData['hemoglobin'] < 12.0) { 
            $riskScore += 20; 
            $symptomCount++;
        }
        if ($validatedData['trombosit'] < 150000) { 
            $riskScore += 10; 
            $symptomCount++;
        }

        // Faktor risiko serius (0-30 poin)
        if ($validatedData['asam_urat'] > 7.0) { 
            $riskScore += 10; 
            $symptomCount++;
        }
        if ($validatedData['ldh'] > 250.0) { 
            $riskScore += 10; 
            $symptomCount++;
        }

        // Memastikan skor maksimal 100
        $riskScore = min($riskScore, 100);

        // Jika hanya satu faktor yang dipilih, tentukan risiko sebagai Low Risk (1-5%)
        if ($symptomCount == 1) {
            $prediction = 'Low Risk';
            $riskScore = rand(1, 5); // Skor risiko dibatasi antara 1% hingga 5%
        } else {
            // Prediksi risiko berdasarkan risk_score
            if ($riskScore < 25) {
                $prediction = 'Low Risk';
            } elseif ($riskScore >= 25 && $riskScore <= 75) {
                $prediction = 'Medium Risk';
            } else {
                $prediction = 'High Risk';
            }

            // Skor risiko final sesuai kategori risiko
            if ($prediction == 'Low Risk') {
                $riskScore = rand(1, 25); // Rentang risiko 1% - 25% untuk Low Risk
            } elseif ($prediction == 'Medium Risk') {
                $riskScore = rand(26, 75); // Rentang risiko 26% - 75% untuk Medium Risk
            } else {
                $riskScore = rand(76, 100); // Rentang risiko 76% - 100% untuk High Risk
            }
        }

        // Menyimpan hasil prediksi ke dalam database
        $predictionRecord = Leukimia::create(array_merge(
            $validatedData,
            ['risk_score' => $riskScore, 'prediction' => $prediction]
        ));

        // Mengembalikan response dengan format yang diinginkan
        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'blood_test' => [
                'nama_pasien' => $validatedData['nama_pasien'],  // Menambahkan nama_pasien dalam response
                'sel_darah_putih' => $validatedData['sel_darah_putih'],
                'hemoglobin' => $validatedData['hemoglobin'],
                'trombosit' => $validatedData['trombosit'],
                'asam_urat' => $validatedData['asam_urat'],
                'ldh' => $validatedData['ldh'],
                'created_at' => $predictionRecord->created_at->toISOString(),
                'updated_at' => $predictionRecord->updated_at->toISOString(),
                'id' => $predictionRecord->id,
            ],
            'prediction' => $prediction,
            'risk_score' => $riskScore,
        ]);
    }

    public function index(Request $request)
    {
        $predictions = Leukimia::with('diseaseDetail')
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->get();

        return response()->json($predictions);
    }
}