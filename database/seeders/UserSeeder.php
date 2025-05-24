<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Jurusan;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // === BAPENDIK ===
        User::create([
            'name' => 'Admin Bapendik',
            'email' => 'bapendik@sikap.test',
            'password' => Hash::make('password'),
            'role' => 'bapendik',
        ]);

        // === DOSEN ===
        $dosen1 = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'dosen1@sikap.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        Dosen::create([
            'user_id' => $dosen1->id,
            'jurusan_id' => 1, // Teknik Informatika
            'nidn' => '0012345601',
            'is_komisi' => true, // Dosen ini juga anggota komisi
        ]);

        $dosen2 = User::create([
            'name' => 'Retno Wulandari, M.Kom.',
            'email' => 'dosen2@sikap.test',
            'password' => Hash::make('password'),
            'role' => 'dosen',
        ]);
        Dosen::create([
            'user_id' => $dosen2->id,
            'jurusan_id' => 2, // Sistem Informasi
            'nidn' => '0012345602',
        ]);

        // === MAHASISWA ===
        $mhs1 = User::create([
            'name' => 'Agus Purnomo',
            'email' => 'mahasiswa1@sikap.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'user_id' => $mhs1->id,
            'jurusan_id' => 1, // Teknik Informatika
            'nim' => '200411100100',
            'tahun_masuk' => 2020,
        ]);

        $mhs2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'mahasiswa2@sikap.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);
        Mahasiswa::create([
            'user_id' => $mhs2->id,
            'jurusan_id' => 2, // Sistem Informasi
            'nim' => '210411100200',
            'tahun_masuk' => 2021,
        ]);
    }
}
