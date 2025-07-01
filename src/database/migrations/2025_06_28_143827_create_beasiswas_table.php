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
        Schema::create('beasiswas', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->text('deskripsi')->nullable();
    $table->string('penyelenggara')->nullable(); // ← tambahkan ini
    $table->decimal('nominal', 12, 2)->nullable();
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beasiswas');
    }
};