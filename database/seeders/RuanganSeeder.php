<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ruangan; // Import model Ruangan

class RuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Seminar 1'],
            [
                'lokasi_gedung' => 'Gedung F',
                'kapasitas' => 50,
                'fasilitas' => 'AC, Proyektor, Papan Tulis',
                'is_tersedia' => true,
            ]
        );

        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Seminar 2'],
            [
                'lokasi_gedung' => 'Gedung F',
                'kapasitas' => 40,
                'fasilitas' => 'AC, Proyektor',
                'is_tersedia' => true,
            ]
        );

        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Seminar 3'],
            [
                'lokasi_gedung' => 'Gedung F',
                'kapasitas' => 30,
                'fasilitas' => 'AC, Papan Tulis',
                'is_tersedia' => true,
            ]
        );

        Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Ruang Seminar 4'],
            [
                'lokasi_gedung' => 'Gedung F',
                'kapasitas' => 30,
                'fasilitas' => 'AC',
                'is_tersedia' => false, // Contoh ruangan yang ditandai tidak tersedia
            ]
        );
    }
}
