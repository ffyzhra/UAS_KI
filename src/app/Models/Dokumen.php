<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
    'pendaftaran_id',
    'ktp_path',
    'kk_path',
    'ijazah_path',
    'transkrip_path',
];

public function pendaftaran()
{
    return $this->belongsTo(Pendaftaran::class);
}
}