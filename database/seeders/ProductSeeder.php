<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'uuid' => \Str::uuid(),
                'name' => 'CardBoard Box',
                'price_per_unit' => 5,
                'price_sell_per_unit' => 2.5,
                'unit' => 'gr',
                'weight_for_point' => 800,
                'point_per_weight' => 1,
                'minimal_weight' => 800,
                'minimal_sell_weight' => 800,
                'image' => '-'
            ],
            [
                'uuid' => \Str::uuid(),
                'name' => 'Paper',
                'price_per_unit' => 11,
                'price_sell_per_unit' => 5.5,
                'unit' => 'gr',
                'weight_for_point' => 200,
                'point_per_weight' => 1,
                'minimal_weight' => 500,
                'minimal_sell_weight' => 500,
                'image' => '-'
            ],
            [
                'uuid' => \Str::uuid(),
                'name' => 'Plastic Bottles',
                'price_per_unit' => 3,
                'price_sell_per_unit' => 1.5,
                'unit' => 'gr',
                'weight_for_point' => 200,
                'point_per_weight' => 1,
                'minimal_weight' => 300,
                'minimal_sell_weight' => 300,
                'image' => '-'
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
