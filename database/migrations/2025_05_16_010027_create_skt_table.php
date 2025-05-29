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
        Schema::create('skt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_period_id')->constrained();
            $table->foreignId('pyd_id')->constrained('users');
            $table->foreignId('ppp_id')->constrained('users');
            $table->text('aktiviti_projek')->nullable();
            $table->text('petunjuk_prestasi')->nullable();
            $table->text('laporan_akhir_pyd')->nullable();
            $table->text('ulasan_akhir_ppp')->nullable();
            $table->enum('status', ['draf', 'diserahkan', 'disahkan'])->default('draf');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skt');
    }
};
