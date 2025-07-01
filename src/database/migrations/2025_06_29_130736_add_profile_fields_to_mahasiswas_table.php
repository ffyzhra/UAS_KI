<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    // Kolom sudah ada, jadi tidak perlu menambahkan apa pun
}

public function down(): void
{
    // Biarkan kosong atau hapus kolom jika ingin rollback
}
};
