<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\SuratPengantar;
use App\Models\Dosen;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanKpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Relasi ini biasanya akan di-override di seeder, tapi baik untuk punya default
            'mahasiswa_id' => Mahasiswa::factory(),
            'surat_pengantar_id' => SuratPengantar::factory(),

            'judul_kp' => 'Rancang Bangun Sistem Informasi ' . fake()->company(),
            'instansi_lokasi' => 'PT. ' . fake()->company(),
            'dosen_pembimbing_id' => null, // Defaultnya belum ada pembimbing
            'proposal_kp' => 'proposal_kp/contoh.pdf',
            'surat_keterangan' => 'surat_keterangan_instansi/contoh.pdf',

            // NILAI DEFAULT UNTUK KOLOM YANG HILANG
            'tanggal_pengajuan' => fake()->dateTimeBetween('-6 months', 'now'),

            'status_komisi' => 'direview',
            'alasan_ditolak' => null,

            // Gunakan nama kolom yang sudah kamu ubah
            'tanggal_mulai_kp' => null,
            'tanggal_selesai_kp' => null,

            'status_kp' => 'pengajuan',
            'spk_dicetak_at' => null,
            'spk_diambil_at' => null,
            'catatan_spk' => null,
        ];
    }
}
