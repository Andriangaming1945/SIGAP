<?php
namespace Database\Seeders;

use App\Models\HeartDiseasePrediction;
use App\Models\StrokePrediction;
use App\Models\Patient;
use App\Models\DiseaseDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DiseaseDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiseaseDetail::query()->delete();
    
        $predictionTypes = [
            [
                'model' => HeartDiseasePrediction::class,
                'name' => 'Heart Disease',
                'default_description' => 'Penyakit jantung adalah kondisi di mana fungsi jantung terganggu, biasanya disebabkan oleh penyempitan atau penyumbatan pembuluh darah yang mengurangi aliran darah ke jantung, serta masalah struktural atau ritme jantung yang tidak normal. Penyakit ini dapat menyebabkan serangan jantung, gagal jantung, atau aritmia.'
            ],
            [
                'model' => StrokePrediction::class,
                'name' => 'Stroke',
                'default_description' => 'Penyakit ini adalah kondisi ketika suplai darah ke otak terganggu, sehingga sel-sel otak kekurangan oksigen dan nutrisi, yang menyebabkan kerusakan pada jaringan otak.'
            ],
            [
                'model' => Patient::class,
                'name' => 'Diabetes',
                'default_description' => 'penyakit ini adalah gangguan metabolisme yang menyebabkan kadar gula darah tinggi. Penyakit ini disebabkan oleh tubuh yang tidak mampu memproduksi insulin yang cukup atau tidak efektif dalam menggunakan insulin. Diabetes dibagi menjadi dua tipe utama, yaitu diabetes tipe 1 dan tipe 2. Tipe 1 disebabkan oleh kerusakan sel pankreas yang memproduksi insulin, sedangkan tipe 2 terkait dengan resistensi insulin dan sering dikaitkan dengan pola hidup yang tidak sehat. Gejala umum diabetes meliputi sering haus, sering buang air kecil, kelelahan, dan luka yang sulit sembuh.'
            ]
        ];
    
        foreach ($predictionTypes as $type) {
            $model = new $type['model'];
            
            // Query untuk semua model
            $query = $model::select('risk_score');
            if (Schema::hasColumn($model->getTable(), 'description')) {
                $query->addSelect('description');
            }
            
            $data = $query->distinct()
                         ->get()
                         ->map(function($item) {
                             // Gunakan nilai asli untuk semua model
                             $score = min(max($item->risk_score, 0), 100);
                             return (object)[
                                 'status' => $score >= 50 ? 'High Risk' : 'Low Risk',
                                 'risk_score' => $score,
                                 'description' => $item->description ?? null
                             ];
                         });
    
            if ($data->isEmpty()) {
                DiseaseDetail::create([
                    'name' => $type['name'],
                    'status' => 'Low Risk',
                    'description' => $type['default_description'],
                    'risk_score' => 0
                ]);
                continue;
            }
    
            foreach ($data as $item) {
                DiseaseDetail::create([
                    'name' => $type['name'],
                    'status' => $item->status,
                    'description' => $item->description ?? $type['default_description'],
                    'risk_score' => $item->risk_score
                ]);
            }
        }
    }
}