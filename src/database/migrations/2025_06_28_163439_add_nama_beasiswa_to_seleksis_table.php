<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::table('seleksis', function (Blueprint $table) {
        $table->string('nama_beasiswa')->after('pendaftaran_id');
    });
}

public function down(): void
{
    Schema::table('seleksis', function (Blueprint $table) {
        $table->dropColumn('nama_beasiswa');
    });
}
};
