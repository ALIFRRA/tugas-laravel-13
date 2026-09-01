<?php
/**
     * Definition.
     *
     * @return public definition
     */


namespace Database\Factories;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/** @extends Factory<Guru> */
class GuruFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'user_id' => fn () => User::factory()->create()->id,
            'nama' => fake()->name(),
            'nip' => '19' . fake()->number-between(8000, 9999) . sprintf('%04d', fake()->number-between(1, 9999)) . '200' . fake()->number-between(1, 9) . '01',
            'no_telepon' => '0812-' . fake()->number-between(100, 999) . '-' . sprintf('%04d', fake()->number-between(1, 9999)),
            'wali_kelas' => null,
        ];
    }

    public static function withUser($user): static
    {
        return static->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}