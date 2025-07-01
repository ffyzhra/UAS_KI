<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'nik',
        'alamat',
        'jurusan',       // jika disimpan sebagai teks biasa
        'semester',
        'ipk',
        'email',
        'no_telp',
        'beasiswa_id',
    ];

    // Relasi ke beasiswa yang didaftarkan
   public function beasiswa()
{
    return $this->belongsTo(Beasiswa::class);
}
}