<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hipertensis', function (Blueprint $table) {
            $table->id();
            $table->boolean('nyeri_dada');
            $table->boolean('sesak_nafas');
            $table->boolean('pusing');
            $table->boolean('mual');
            $table->boolean('kelelahan');
            $table->boolean('tekanan_darah_tinggi');
            $table->boolean('riwayat_hipertensi');
            $table->integer('risk_score');
            $table->string('prediction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hipertensis');
    }
};
