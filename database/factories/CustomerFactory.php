<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'user_id' => User::factory(),
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'point' => $this->faker->numberBetween(0, 1000)
        ];
    }

    public function withPoints($points)
    {
        return $this->state(function (array $attributes) use ($points) {
            return [
                'points' => $points
            ];
        });
    }

    public function noPoints()
    {
        return $this->state(function (array $attributes) {
            return [
                'points' => 0
            ];
        });
    }
}
