<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('seleksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pendaftaran_id')->constrained()->onDelete('cascade');
    $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete();
    $table->enum('hasil', ['diterima', 'ditolak']);
    $table->text('catatan')->nullable();
    $table->timestamp('tanggal_seleksi')->nullable();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seleksis');
    }
};
