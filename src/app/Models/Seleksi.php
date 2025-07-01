<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seleksi extends Model
{
    protected $fillable = [
        'pendaftaran_id',
        'reviewer_id',
        'hasil',
        'catatan',
        'tanggal_seleksi',
        'nama_beasiswa',
    ];

    // Relasi ke Pendaftaran
    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    // Relasi tidak langsung ke Mahasiswa (via Pendaftaran)
    public function mahasiswa()
    {
        return $this->hasOneThrough(
            Mahasiswa::class,
            Pendaftaran::class,
            'id',              // foreign key di Pendaftaran
            'id',              // foreign key di Mahasiswa
            'pendaftaran_id',  // foreign key di Seleksi
            'mahasiswa_id'     // foreign key di Pendaftaran
        );
    }

    // Relasi ke Reviewer (jika ada modelnya)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}