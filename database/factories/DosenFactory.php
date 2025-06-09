<?php
namespace Database\Factories;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->dosen(), // Buat user baru jika tidak diberikan
            'jurusan_id' => Jurusan::all()->random()->id,
            'nidn' => fake()->unique()->numerify('##########'),
            'bidang_keahlian' => 'Sistem Cerdas',
            'is_komisi' => false,
        ];
    }
}
