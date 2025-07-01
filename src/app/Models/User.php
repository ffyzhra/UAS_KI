<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // ✅ Tambahkan ini

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // ✅ Tambahkan HasRoles di sini

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
}