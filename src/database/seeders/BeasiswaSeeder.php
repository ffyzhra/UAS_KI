<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('beasiswas')->insert([
            [
                'nama' => 'Beasiswa Prestasi Akademik',
                'deskripsi' => 'Diberikan kepada mahasiswa dengan IPK di atas 3.5 dan prestasi akademik unggul.',
                'nominal' => 3000000,
                'min_ipk' => 3.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Beasiswa UKT Bantuan',
                'deskripsi' => 'Diperuntukkan bagi mahasiswa yang membutuhkan bantuan pembayaran UKT.',
                'nominal' => 1500000,
                'min_ipk' => 2.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Beasiswa Non-Akademik',
                'deskripsi' => 'Untuk mahasiswa berprestasi di bidang non-akademik seperti olahraga, seni, dan organisasi.',
                'nominal' => 2000000,
                'min_ipk' => 2.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}