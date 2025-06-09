<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'mahasiswa', // Default
        ];
    }

    public function dosen(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'dosen'])
            ->afterCreating(function (User $user) {
                Dosen::factory()->create(['user_id' => $user->id]);
            });
    }

    public function mahasiswa(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'mahasiswa'])
            ->afterCreating(function (User $user) {
                Mahasiswa::factory()->create(['user_id' => $user->id]);
            });
    }

    public function bapendik(): Factory
    {
        return $this->state(fn (array $attributes) => ['role' => 'bapendik']);
    }
}
