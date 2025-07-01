<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('mahasiswas', 'beasiswa_id')) {
            Schema::table('mahasiswas', function (Blueprint $table) {
                $table->foreignId('beasiswa_id')->nullable()->constrained('beasiswas')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'beasiswa_id')) {
                $table->dropForeign(['beasiswa_id']);
                $table->dropColumn('beasiswa_id');
            }
        });
    }
};