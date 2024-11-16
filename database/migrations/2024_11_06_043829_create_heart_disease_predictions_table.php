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
        Schema::create('heart_disease_predictions', function (Blueprint $table) {
            $table->id();
            $table->integer('age');
            $table->integer('blood_pressure');
            $table->integer('cholesterol');
            $table->integer('heart_rate');
            $table->boolean('smoking');
            $table->boolean('diabetes');
            $table->boolean('family_history');
            $table->boolean('physical_inactivity');
            $table->boolean('stress');
            $table->boolean('obesity');
            $table->boolean('cad')->after('obesity');  // Coronary Artery Disease (boolean)
            $table->boolean('pitting_edema')->after('cad');  // Pitting Edema (boolean)
            $table->boolean('anemia')->after('pitting_edema');  // Anemia (boolean)
            $table->boolean('chf')->after('anemia');
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
        Schema::dropIfExists('heart_disease_predictions');
    }
};
