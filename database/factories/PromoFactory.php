<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->words(3, true),
            'point_price' => $this->faker->numberBetween(100, 1000),
            'multiply_point' => 1,
            'type_transaction' => $this->faker->randomElement(['Buy', 'Sell']),
            'note' => $this->faker->sentence(),
            'type_promo' => 'point',
            'discount' => 0
        ];
    }

    public function pointMultiplier()
    {
        return $this->state(function (array $attributes) {
            return [
                'uuid' => Str::uuid(),
                'type_promo' => 'point',
                'multiply_point' => $this->faker->numberBetween(2, 5),
                'discount' => 0
            ];
        });
    }

    public function discount()
    {
        return $this->state(function (array $attributes) {
            return [
                'uuid' => Str::uuid(),
                'type_promo' => 'discount',
                'multiply_point' => 1,
                'discount' => $this->faker->numberBetween(5, 30)
            ];
        });
    }
}
