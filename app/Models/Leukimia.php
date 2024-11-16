<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leukimia extends Model
{
    protected $fillable = [
        'nama_pasien',
        'sel_darah_putih',
        'hemoglobin',
        'trombosit',
        'asam_urat',
        'ldh',
        'skor_risiko',
        'prediksi'
    ];
}
