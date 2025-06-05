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
            
            // Awal Tahun fields
            $table->json('skt_awal')->nullable()->comment('JSON array of awal tahun SKT items');
            $table->timestamp('skt_awal_submitted_at')->nullable();
            $table->timestamp('skt_awal_approved_at')->nullable();
            
            // Pertengahan Tahun fields
            $table->json('skt_pertengahan')->nullable()->comment('JSON array of pertengahan tahun adjustments');
            $table->timestamp('skt_pertengahan_submitted_at')->nullable();
            $table->timestamp('skt_pertengahan_approved_at')->nullable();
            
            // Akhir Tahun fields
            $table->text('skt_akhir_pyd')->nullable()->comment('PYD final report');
            $table->text('skt_akhir_ppp')->nullable()->comment('PPP final report');
            $table->timestamp('skt_akhir_pyd_submitted_at')->nullable();
            $table->timestamp('skt_akhir_ppp_submitted_at')->nullable();
            
            // Status tracking
            $table->string('status')->default('draf')->comment('draf, diserahkan_awal, disahkan_awal, diserahkan_pertengahan, disahkan_pertengahan, selesai, tidak_diserahkan');
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['evaluation_period_id', 'pyd_id']);
            $table->index(['status']);
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