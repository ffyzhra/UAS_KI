<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beasiswa extends Model
{
    use HasFactory;

   protected $fillable = [
    'nama',
    'deskripsi',
    'penyelenggara',
    'nominal',
    'min_ipk',
    'status',
    ];
public function mahasiswas()
{
    return $this->hasMany(Mahasiswa::class);
}
}