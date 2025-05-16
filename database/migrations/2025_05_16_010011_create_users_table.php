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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('jawatan')->nullable();
            $table->string('gred')->nullable();
            $table->string('kementerian_jabatan')->nullable();
            $table->foreignId('pyd_group_id')->nullable()->constrained();
            $table->enum('peranan', ['super_admin', 'admin', 'ppp', 'ppk', 'pyd'])->default('pyd');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
