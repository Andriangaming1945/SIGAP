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
        Schema::create('tbc_predictions', function (Blueprint $table) {
            $table->id();
            $table->boolean('batuk')->default(false);  // Batuk lebih dari 2 minggu
$table->boolean('batuk_berdarah')->default(false);  // Batuk berdarah
$table->boolean('demam')->default(false);  // Demam tidak jelas penyebabnya
$table->boolean('keringat_malam')->default(false);  // Berkeringat malam
$table->boolean('penurunan_berat_badan')->default(false);  // Penurunan berat badan
$table->boolean('kelelahan')->default(false);  // Kelelahan
$table->boolean('kontak_tbc')->default(false);  // Riwayat kontak dengan penderita TBC
$table->boolean('perjalanan_tbc_endemic')->default(false);  // Riwayat perjalanan ke daerah endemis TBC
$table->decimal('risk_score', 5, 2)->nullable();  // Menambahkan kolom risk_score
$table->string('prediction')->nullable();  // Menambahkan kolom prediction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbc_predictions');
    }
};
