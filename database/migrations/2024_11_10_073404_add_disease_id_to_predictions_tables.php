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
            $table->foreignId('disease_id')->nullable()->constrained('disease_details');
        });
        
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('disease_id')->nullable()->constrained('disease_details');
        });
        
        Schema::table('stroke_predictions', function (Blueprint $table) {
            $table->foreignId('disease_id')->nullable()->constrained('disease_details');
        });

        Schema::table('tbc_predictions', function (Blueprint $table) {
            $table->foreignId('disease_id')->nullable()->constrained('disease_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('heart_disease_predictions', function (Blueprint $table) {
            $table->dropForeign(['disease_id']);
            $table->dropColumn('disease_id');
        });
    
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['disease_id']);
            $table->dropColumn('disease_id');
        });
    
        Schema::table('stroke_predictions', function (Blueprint $table) {
            $table->dropForeign(['disease_id']);
            $table->dropColumn('disease_id');
        });

        Schema::table('tbc_predictions', function (Blueprint $table) {
            $table->dropForeign(['disease_id']);
            $table->dropColumn('disease_id');
        });
    }
};
