<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Promo;
use Illuminate\Support\Facades\Artisan;
use Str;
use Hash;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected $customer;
    protected $products;

    protected $cardboard;
    protected $paper;
    protected $plastic;
    protected $buyPromo;
    protected $sellPromo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\App\Http\Middleware\RoleMiddleware::class);


        // Create user and customer
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        // Create associated customer
        $this->customer = Customer::factory()->create([
            'user_id' => $this->user->id,
            'email' => $this->user->email,
            'point' => 1000
        ]);

        // Create test products
        $this->cardboard = Product::factory()->cardboard()->create();
        $this->paper = Product::factory()->paper()->create();
        $this->plastic = Product::factory()->plastic()->create();

        $this->buyPromo = Promo::factory()->create([
            'type_transaction' => 'Buy',
            'discount' => 10,
            'point_price' => 500,
            'name' => 'Buy Promo'
        ]);

        $this->sellPromo = Promo::factory()->pointMultiplier()->create([
            'type_transaction' => 'Sell',
            'multiply_point' => 2,
            'point_price' => 500,
            'name' => 'Sell Promo'
        ]);
    }

    public function test_customer_can_buy_without_promo()
    {
        $this->actingAs($this->user);

        $product = $this->cardboard;
        $quantity = 2;
        $expectedPrice = $product->price_sell_per_unit * $quantity;

        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => $expectedPrice,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('transactions', [
            'customer_id' => $this->customer->id,
            'type' => 'Buy',
            'is_promo' => false,
            'total_price' => $expectedPrice
        ]);
    }

    public function test_customer_can_sell_without_promo()
    {
        $this->actingAs($this->user);

        $product = $this->cardboard;
        $quantity = 2;
        $expectedPoints = (int) ceil(($quantity * 1000 * $product->point_per_weight) / $product->weight_for_point);

        $response = $this->postJson('/transactions/store', [
            'title' => 'Sell',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 80000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(201);

        $this->assertEquals(
            1000 + $expectedPoints,
            $this->customer->fresh()->point
        );

        $this->assertDatabaseHas('transactions', [
            'customer_id' => $this->customer->id,
            'type' => 'Sell',
            'is_promo' => false
        ]);
    }

    public function test_customer_can_buy_with_promo()
    {
        $this->actingAs($this->user);

        // Give customer a promo
        $customerPromo = $this->customer->customerPromo()->create([
            'customer_id' => $this->customer->id,
            'promo_id' => $this->buyPromo->id,
            'valid' => true
        ]);

        // Buy 2kg of cardboard with promo
        $product = $this->cardboard;
        $quantity = 2;
        $originalPrice = $product->price_sell_per_unit * $quantity;
        $expectedPrice = $originalPrice - ($originalPrice * ($this->buyPromo->discount / 100));


        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => 2,
            'unit' => 'kg', //unit is kg
            'destination' => 'Test Address',
            'price' => $expectedPrice,
            'customer_promo_id' => $customerPromo->id
        ]);

        $response->assertStatus(201);

        // Check if promo was applied
        $this->assertDatabaseHas('transactions', [
            'customer_id' => $this->customer->id,
            'type' => 'Buy',
            'is_promo' => true
        ]);

        // Check if promo was marked as used
        $this->assertDatabaseHas('customer_promo', [
            'id' => $customerPromo->id,
            'valid' => false
        ]);
    }

    public function test_customer_can_sell_with_point_multiplier_promo()
    {
        $this->actingAs($this->user);
        $this->assertAuthenticated();

        // Give customer a promo
        $customerPromo = $this->customer->customerPromo()->create([
            'customer_id' => $this->customer->id,
            'promo_id' => $this->sellPromo->id,
            'valid' => true
        ]);

        // Sell 2kg of cardboard with promo
        $product = $this->cardboard;
        $quantity = 2; // 2kg
        $expectedPoints = ($quantity * 1000 * $product->point_per_weight / $product->weight_for_point) * $this->sellPromo->multiply_point;

        $response = $this->post('/transactions/store', [
            'title' => 'Sell',
            'product_id' => $product->id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 80000,
            'customer_promo_id' => $customerPromo->id
        ]);

        $response->assertStatus(201);

        // Check if points were multiplied correctly
        $this->assertEquals(
            1000 + $expectedPoints, // Initial points + earned points
            $this->customer->fresh()->point
        );
    }
}
