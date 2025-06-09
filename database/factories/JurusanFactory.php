<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode' => fake()->unique()->lexify('??'),
            'nama' => fake()->words(2, true),
            'fakultas' => 'Fakultas Teknik',
            'jenjang' => 'S1',
        ];
    }
}
