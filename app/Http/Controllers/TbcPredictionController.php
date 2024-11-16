<?php

namespace App\Http\Controllers;

use App\Models\tbc_predictions;
use Illuminate\Http\Request;

class TbcPredictionController extends Controller
{
    public function predic(Request $request)
    {
        $validatedData = $request->validate([
            'batuk' => 'required|boolean',
            'batuk_berdarah' => 'required|boolean',
            'demam' => 'required|boolean',
            'keringat_malam' => 'required|boolean',
            'penurunan_berat_badan' => 'required|boolean',
            'kelelahan' => 'required|boolean',
            'kontak_tbc' => 'required|boolean',
            'perjalanan_tbc_endemic' => 'required|boolean',
        ]);

        $riskScore = 0;
        $symptomCount = 0; // Menghitung jumlah gejala yang dipilih

        // Faktor utama (0-50 poin)
        if ($validatedData['batuk']) { $riskScore += 15; $symptomCount++; }
        if ($validatedData['batuk_berdarah']) { $riskScore += 20; $symptomCount++; }
        if ($validatedData['demam']) { $riskScore += 10; $symptomCount++; }

        // Faktor risiko serius (0-30 poin)
        if ($validatedData['keringat_malam']) { $riskScore += 10; $symptomCount++; }
        if ($validatedData['penurunan_berat_badan']) { $riskScore += 10; $symptomCount++; }
        if ($validatedData['kelelahan']) { $riskScore += 10; $symptomCount++; }

        // Faktor kontak dan riwayat perjalanan (0-20 poin)
        if ($validatedData['kontak_tbc']) { $riskScore += 15; $symptomCount++; }
        if ($validatedData['perjalanan_tbc_endemic']) { $riskScore += 5; $symptomCount++; }

        // Memastikan skor maksimal 100
        $riskScore = min($riskScore, 100);

        // Jika hanya satu gejala yang dipilih, tentukan risiko sebagai Low Risk (1-5%)
        if ($symptomCount == 1) {
            $prediction = 'Low Risk';
            $riskScore = rand(1, 5); // Skor risiko dibatasi antara 1% hingga 5%
        } else {
            // Prediksi TBC berdasarkan risk_score
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
        $predictionRecord = tbc_predictions::create(array_merge(
            $validatedData,
            ['risk_score' => $riskScore, 'prediction' => $prediction]
        ));

        // Mengembalikan response dengan format yang diinginkan
        return response()->json([
            'message' => 'Data berhasil disimpan!',
            'tuberculosis' => [
                'batuk' => $validatedData['batuk'],
                'batuk_berdarah' => $validatedData['batuk_berdarah'],
                'demam' => $validatedData['demam'],
                'keringat_malam' => $validatedData['keringat_malam'],
                'penurunan_berat_badan' => $validatedData['penurunan_berat_badan'],
                'kelelahan' => $validatedData['kelelahan'],
                'kontak_tbc' => $validatedData['kontak_tbc'],
                'perjalanan_tbc_endemic' => $validatedData['perjalanan_tbc_endemic'],
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
        $predictions = tbc_predictions::with('diseaseDetail')
            ->whereBetween('created_at', [$request->startDate, $request->endDate])
            ->get();

        return response()->json($predictions);
    }
}




