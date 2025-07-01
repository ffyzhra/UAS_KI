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
        Schema::table('beasiswas', function (Blueprint $table) {
            // Menambahkan kolom 'penyelenggara' setelah 'deskripsi'
            $table->string('penyelenggara')->nullable()->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('beasiswas', function (Blueprint $table) {
            // Menghapus kolom 'penyelenggara' jika rollback
            $table->dropColumn('penyelenggara');
        });
    }
};