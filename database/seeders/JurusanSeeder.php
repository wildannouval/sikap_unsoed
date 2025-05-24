<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'kode' => 'IF',
            'nama' => 'Teknik Informatika',
            'fakultas' => 'Fakultas Teknik dan Ilmu Komputer',
            'jenjang' => 'S1',
        ]);

        Jurusan::create([
            'kode' => 'SI',
            'nama' => 'Sistem Informasi',
            'fakultas' => 'Fakultas Teknik dan Ilmu Komputer',
            'jenjang' => 'S1',
        ]);
    }
}
