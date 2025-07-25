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
    Schema::create('mahasiswas', function (Blueprint $table) {
        $table->string('nim')->unique();
        $table->string('nama');
        $table->string('nik');
        $table->text('alamat')->nullable();
        $table->string('jurusan');
        $table->unsignedTinyInteger('semester');
        $table->decimal('ipk', 3, 2);
        $table->string('email');
        $table->string('no_telp');
        $table->foreignId('beasiswa_id')->constrained()->onDelete('cascade');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
