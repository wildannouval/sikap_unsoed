<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konsultasi>
 */
class KonsultasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Data default palsu untuk setiap record konsultasi
        return [
            'tanggal_konsultasi' => fake()->dateTimeBetween('-3 months', '-1 week'),
            'topik_konsultasi' => 'Pembahasan ' . fake()->randomElement(['Bab 1: Pendahuluan', 'Bab 2: Tinjauan Pustaka', 'Bab 3: Metodologi', 'Desain Awal Sistem', 'Implementasi Fitur Login']),
            'hasil_konsultasi' => fake()->paragraph(3),
            'diverifikasi' => false, // Secara default, anggap belum diverifikasi
            'tanggal_verifikasi' => null,
            'catatan_dosen' => null,
        ];
    }
}
