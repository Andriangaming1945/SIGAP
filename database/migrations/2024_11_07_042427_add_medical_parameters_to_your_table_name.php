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
        Schema::table('heart_disease_predictions', function (Blueprint $table) {
            $table->boolean('cad')->after('obesity');  // Coronary Artery Disease (boolean)
            $table->boolean('pitting_edema')->after('cad');  // Pitting Edema (boolean)
            $table->boolean('anemia')->after('pitting_edema');  // Anemia (boolean)
            $table->boolean('chf')->after('anemia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heart_disease_predictions', function (Blueprint $table) {
            $table->dropColumn('cad');
            $table->dropColumn('pitting_edema');
            $table->dropColumn('anemia');
            $table->dropColumn('chf');
        });
    }
};
