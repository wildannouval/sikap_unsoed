<?php
namespace Database\Factories;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->mahasiswa(), // Buat user baru jika tidak diberikan
            'jurusan_id' => Jurusan::all()->random()->id,
            'nim' => 'H1D0' . fake()->unique()->numberBetween(19000, 24000),
            'tahun_masuk' => fake()->numberBetween(2019, 2024),
            'no_hp' => fake()->e164PhoneNumber(),
            'alamat' => fake()->address(),
        ];
    }
}
