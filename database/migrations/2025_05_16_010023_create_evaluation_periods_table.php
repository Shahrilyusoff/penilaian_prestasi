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
        Schema::create('evaluation_periods', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // Removed 'after'
            $table->string('tahun');
            $table->date('tarikh_mula_awal')->nullable();
            $table->date('tarikh_tamat_awal')->nullable();
            $table->date('tarikh_mula_pertengahan')->nullable();
            $table->date('tarikh_tamat_pertengahan')->nullable();
            $table->date('tarikh_mula_akhir')->nullable();
            $table->date('tarikh_tamat_akhir')->nullable();
            $table->date('tarikh_mula_penilaian')->nullable();
            $table->date('tarikh_tamat_penilaian')->nullable();
            $table->timestamps(); // Recommended to track record creation and updates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_periods');
    }
};

