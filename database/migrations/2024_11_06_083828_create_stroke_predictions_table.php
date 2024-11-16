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
        Schema::create('stroke_predictions', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->boolean('hypertension'); 
            $table->boolean('heart_disease'); // Penyakit jantung
            $table->decimal('avg_glucose_level', 5, 2); // Kadar glukosa
            $table->boolean('smoking_status'); // Status merokok
            $table->boolean('ac_near_face'); // Angin AC dekat wajah
            $table->boolean('head_injury'); // Cedera kepala
            $table->boolean('diabetes');
            $table->boolean('obesity');
            $table->boolean('less_exposure_to_sunlight');
            $table->decimal('risk_score', 5, 2);
            $table->string('prediction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stroke_predictions');
    }
};
