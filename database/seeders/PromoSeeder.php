<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promos = [
            [
                'uuid' => \Str::uuid(),
                'name' => 'Diskon 20%',
                'type_promo' => 'discount',
                'discount' => 20,
                'point_price' => 100,
                'type_transaction' => 'buy',
                'note' => 'untuk 1 kali transaksi',
            ],
            [
                'uuid' => \Str::uuid(),
                'name' => 'Double Point',
                'type_promo' => 'point',
                'multiply_point' => 2,
                'point_price' => 40,
                'type_transaction' => 'sell',
                'note' => 'untuk 1 kali transaksi',
            ],
        ];

        foreach ($promos as $promo) {
            \App\Models\Promo::create($promo);
        }
    }
}
