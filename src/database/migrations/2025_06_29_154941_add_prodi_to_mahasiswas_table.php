<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Jangan ulangi kolom yang sudah ada seperti 'nim', 'nama', dsb.
            // Tambahkan hanya jika kolom belum ada.

            if (!Schema::hasColumn('mahasiswas', 'prodi')) {
                $table->string('prodi')->nullable()->after('nik');
            }

            if (!Schema::hasColumn('mahasiswas', 'semester')) {
                $table->integer('semester')->nullable()->after('prodi');
            }

            if (!Schema::hasColumn('mahasiswas', 'no_telp')) {
                $table->string('no_telp')->nullable()->after('semester');
            }

            if (!Schema::hasColumn('mahasiswas', 'email')) {
                $table->string('email')->nullable()->after('no_telp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            // Hapus hanya kolom yang ditambahkan
            $table->dropColumn(['prodi', 'semester', 'no_telp', 'email']);
        });
    }
};