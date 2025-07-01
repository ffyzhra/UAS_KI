<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class MahasiswaUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role mahasiswa jika belum ada
        Role::firstOrCreate(['name' => 'mahasiswa']);

        // Buat user baru
        $user = User::firstOrCreate(
            ['email' => 'fayza@student.com'],
            [
                'name' => 'Fayza Azzahra',
                'password' => bcrypt('password123'),
            ]
        );

        // Assign role mahasiswa
        $user->assignRole('mahasiswa');

        // Buat data mahasiswa terkait user tersebut
        Mahasiswa::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nim' => '12345678',
                'nama' => 'Fayza Azzahra',
                'prodi' => 'Teknik Informatika',
                'jurusan' => 'Informatika',
                'semester' => 4,
                'ipk' => 3.85,
                'email' => 'fayza@student.com',
                'no_telp' => '081234567890',
            ]
        );
    }
}