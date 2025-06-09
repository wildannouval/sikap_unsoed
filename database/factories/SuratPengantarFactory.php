<?php
namespace Database\Factories;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SuratPengantarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mahasiswa_id' => Mahasiswa::factory(),
            'lokasi_penelitian' => 'PT. ' . fake()->company(),
            'penerima_surat' => 'Manajer HRD',
            'alamat_surat' => fake()->address(),
            'status_bapendik' => 'menunggu',
            'tahun_akademik' => now()->year . '/' . (now()->year + 1),
            'tanggal_pengajuan' => now()->subDays(rand(1, 30)),
        ];
    }
}
