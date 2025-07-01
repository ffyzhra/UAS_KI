<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'nik')) {
                $table->string('nik')->after('nama')->nullable();
            }

            if (!Schema::hasColumn('mahasiswas', 'email')) {
                $table->string('email')->after('ipk')->nullable();
            }

            if (!Schema::hasColumn('mahasiswas', 'no_telp')) {
                $table->string('no_telp')->after('email')->nullable();
            }

            if (!Schema::hasColumn('mahasiswas', 'beasiswa_id')) {
                $table->foreignId('beasiswa_id')->nullable()->constrained()->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'nik')) {
                $table->dropColumn('nik');
            }

            if (Schema::hasColumn('mahasiswas', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('mahasiswas', 'no_telp')) {
                $table->dropColumn('no_telp');
            }

            if (Schema::hasColumn('mahasiswas', 'beasiswa_id')) {
                $table->dropConstrainedForeignId('beasiswa_id');
            }
        });
    }
};