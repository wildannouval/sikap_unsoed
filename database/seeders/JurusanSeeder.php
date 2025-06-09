<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        Jurusan::firstOrCreate(['kode' => 'IF'], ['nama' => 'Teknik Informatika', 'fakultas' => 'Fakultas Teknik', 'jenjang' => 'S1']);
        Jurusan::firstOrCreate(['kode' => 'SI'], ['nama' => 'Sistem Informasi', 'fakultas' => 'Fakultas Teknik', 'jenjang' => 'S1']);
        Jurusan::firstOrCreate(['kode' => 'TE'], ['nama' => 'Teknik Elektro', 'fakultas' => 'Fakultas Teknik', 'jenjang' => 'S1']);
        Jurusan::firstOrCreate(['kode' => 'TS'], ['nama' => 'Teknik Sipil', 'fakultas' => 'Fakultas Teknik', 'jenjang' => 'S1']);
    }
}
