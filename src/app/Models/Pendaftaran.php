<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'beasiswa_id',
        'tanggal_daftar',     // tanggal saat mendaftar
        'status',             // status seleksi: 'diterima', 'ditolak', atau 'menunggu'
        'catatan',            // catatan seleksi (opsional)
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke Beasiswa
    public function beasiswa()
    {
        return $this->belongsTo(Beasiswa::class);
    }

    // Relasi ke Seleksi (opsional jika dipisah)
    public function seleksi()
    {
        return $this->hasOne(Seleksi::class);
    }

    // Relasi ke Dokumen
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }
}