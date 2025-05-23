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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_period_id')->constrained();
            $table->foreignId('pyd_id')->constrained('users');
            $table->foreignId('ppp_id')->constrained('users');
            $table->foreignId('ppk_id')->constrained('users');
            $table->text('kegiatan_sumbangan')->nullable();
            $table->text('latihan_dihadiri')->nullable();
            $table->text('latihan_diperlukan')->nullable();
            $table->integer('tempoh_penilaian_ppp_mula')->nullable(); // Years
            $table->integer('tempoh_penilaian_ppp_tamat')->nullable(); // Months
            $table->text('ulasan_keseluruhan_ppp')->nullable();
            $table->text('kemajuan_kerjaya_ppp')->nullable();
            $table->integer('tempoh_penilaian_ppk_mula')->nullable();
            $table->integer('tempoh_penilaian_ppk_tamat')->nullable();
            $table->text('ulasan_keseluruhan_ppk')->nullable();
            $table->enum('status', ['draf_pyd', 'draf_ppp', 'draf_ppk', 'selesai'])->default('draf_pyd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
