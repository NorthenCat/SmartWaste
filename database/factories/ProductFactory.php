<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            'name' => $this->faker->word,
            'price_per_unit' => $this->faker->numberBetween(1, 20),
            'price_sell_per_unit' => $this->faker->numberBetween(1, 10),
            'unit' => 'gr',
            'weight_for_point' => $this->faker->randomElement([200, 500, 800]),
            'point_per_weight' => 1,
            'minimal_weight' => $this->faker->randomElement([300, 500, 800]),
            'minimal_sell_weight' => $this->faker->randomElement([300, 500, 800]),
            'stock' => $this->faker->numberBetween(500, 15000),
            'stock_unit' => $this->faker->randomElement(['gr', 'kg']),
            'image' => '-'
        ];
    }

    public function cardboard()
    {
        return $this->state(function () {
            return [
                'name' => 'CardBoard Box',
                'price_per_unit' => 5,
                'price_sell_per_unit' => 2.5,
                'weight_for_point' => 800,
                'minimal_weight' => 800,
                'minimal_sell_weight' => 800,
                'stock' => 12500,
                'stock_unit' => 'gr'
            ];
        });
    }

    public function paper()
    {
        return $this->state(function () {
            return [
                'name' => 'Paper',
                'price_per_unit' => 11,
                'price_sell_per_unit' => 5.5,
                'weight_for_point' => 200,
                'minimal_weight' => 500,
                'minimal_sell_weight' => 500,
                'stock' => 8,
                'stock_unit' => 'kg'
            ];
        });
    }

    public function plastic()
    {
        return $this->state(function () {
            return [
                'name' => 'Plastic Bottles',
                'price_per_unit' => 3,
                'price_sell_per_unit' => 1.5,
                'weight_for_point' => 200,
                'minimal_weight' => 300,
                'minimal_sell_weight' => 300,
                'stock' => 500,
                'stock_unit' => 'gr'
            ];
        });
    }
}
