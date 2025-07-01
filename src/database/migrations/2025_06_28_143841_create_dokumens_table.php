<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dokumens', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pendaftaran_id')->constrained()->onDelete('cascade');
    $table->string('ktp_path')->nullable();
    $table->string('kk_path')->nullable();
    $table->string('ijazah_path')->nullable();
    $table->string('transkrip_path')->nullable();
    $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};