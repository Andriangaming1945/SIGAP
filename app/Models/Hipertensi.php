<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hipertensi extends Model
{
    protected $fillable = [
        'nyeri_dada',
        'sesak_nafas',
        'pusing',
        'mual',
        'kelelahan',
        'tekanan_darah_tinggi',
        'riwayat_hipertensi',
        'risk_score',
        'prediction',
    ];
}
