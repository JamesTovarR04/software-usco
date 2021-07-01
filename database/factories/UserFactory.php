<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'codigo' => $this->faker->numberBetween(20200000000,20202163883),
            'email_verified_at' => now(),
            'provider' => 'google',
            'provider_id' => $this->faker->numberBetween(20200000000,20202163883),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'program_id' => 418
        ];
    }

    /**
     * El usuario no ha regitrado u programa
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function sinPrograma()
    {
        return $this->state(function (array $attributes) {
            return [
                'program_id' => null,
            ];
        });
    }
}
