<?php

namespace Database\Factories;

use App\Models\PengajuanKp;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SeminarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Relasi ini akan di-override di seeder
            'pengajuan_kp_id' => PengajuanKp::factory(),
            'mahasiswa_id' => Mahasiswa::factory(),

            'judul_kp_final' => fake()->sentence(6),
            'draft_laporan_path' => 'draft_laporan_seminar/default.pdf',

            // NILAI DEFAULT UNTUK KOLOM YANG HILANG
            'tanggal_pengajuan_seminar' => now()->subDays(rand(5, 20)),

            'status_pengajuan' => 'diajukan_mahasiswa', // Default status
        ];
    }
}
