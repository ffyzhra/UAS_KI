<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Beasiswa;
use App\Models\Pendaftaran;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user Admin
        $admin = User::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('super_admin');

        // Opsional: Buat 1 user mahasiswa untuk login (boleh dihapus jika tidak perlu)
        $mahasiswaUser = User::firstOrCreate([
            'email' => 'fayza@student.com',
        ], [
            'name' => 'Fayza Azzahra',
            'password' => bcrypt('mahasiswa123'),
        ]);
        $mahasiswaUser->assignRole('mahasiswa');

        // Buat beasiswa (pastikan kolom 'nominal' juga ada jika pakai default database)
        $beasiswa = Beasiswa::firstOrCreate([
            'nama' => 'BSI Scholarship',
        ], [
            'deskripsi' => 'Beasiswa unggulan untuk mahasiswa berprestasi.',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonth(),
            'nominal' => 5000000, // pastikan ini disesuaikan jika kolom ini wajib
        ]);

        // Ambil semua mahasiswa
        $semuaMahasiswa = Mahasiswa::all();

        foreach ($semuaMahasiswa as $mahasiswa) {
            // Cek apakah pendaftaran sudah ada
            Pendaftaran::firstOrCreate([
                'mahasiswa_id' => $mahasiswa->id,
                'beasiswa_id' => $beasiswa->id,
            ]);
        }
    }
}