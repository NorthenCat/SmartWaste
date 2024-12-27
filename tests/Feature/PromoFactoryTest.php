<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Promo;

class PromoFactoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_default_promo_factory_state()
    {
        $promo = Promo::factory()->create();

        $this->assertNotNull($promo->uuid);
        $this->assertNotNull($promo->name);
        $this->assertIsString($promo->name);
        $this->assertGreaterThanOrEqual(100, $promo->point_price);
        $this->assertLessThanOrEqual(1000, $promo->point_price);
        $this->assertEquals(1, $promo->multiply_point);
        $this->assertContains($promo->type_transaction, ['Buy', 'Sell']);
        $this->assertNotNull($promo->note);
        $this->assertEquals('point', $promo->type_promo);
        $this->assertEquals(0, $promo->discount);
    }

    public function test_point_multiplier_state()
    {
        $promo = Promo::factory()->pointMultiplier()->create();

        $this->assertNotNull($promo->uuid);
        $this->assertGreaterThanOrEqual(2, $promo->multiply_point);
        $this->assertLessThanOrEqual(5, $promo->multiply_point);
        $this->assertEquals('point', $promo->type_promo);
        $this->assertEquals(0, $promo->discount);
    }

    public function test_discount_state()
    {
        $promo = Promo::factory()->discount()->create();

        $this->assertNotNull($promo->uuid);
        $this->assertEquals(1, $promo->multiply_point);
        $this->assertEquals('discount', $promo->type_promo);
        $this->assertGreaterThanOrEqual(5, $promo->discount);
        $this->assertLessThanOrEqual(30, $promo->discount);
    }

    public function test_create_buy_promo_with_specific_values()
    {
        $promo = Promo::factory()->create([
            'type_transaction' => 'Buy',
            'discount' => 10,
            'point_price' => 500,
            'name' => 'Test Promo'
        ]);

        $this->assertEquals('Buy', $promo->type_transaction);
        $this->assertEquals(10, $promo->discount);
        $this->assertEquals(500, $promo->point_price);
        $this->assertEquals('Test Promo', $promo->name);
    }

    public function test_create_sell_promo_with_specific_values()
    {
        $promo = Promo::factory()->create([
            'type_transaction' => 'Sell',
            'multiply_point' => 2,
            'point_price' => 500,
            'name' => 'Test Promo'
        ]);

        $this->assertEquals('Sell', $promo->type_transaction);
        $this->assertEquals(2, $promo->multiply_point);
        $this->assertEquals(500, $promo->point_price);
        $this->assertEquals('Test Promo', $promo->name);
    }
}
