<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tbc_predictions extends Model
{
    protected $fillable = [
        'batuk',
'batuk_berdarah',
'demam',
'keringat_malam',
'penurunan_berat_badan',
'kelelahan',
'kontak_tbc',
'perjalanan_tbc_endemic',
'risk_score',
'prediction'
    ];
}
