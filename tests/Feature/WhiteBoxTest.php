<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\CustomerPromo;
use App\Models\Product;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WhiteBoxTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $customer;
    private $product;

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
        $this->product = Product::factory()->create([
            'stock' => 100,
            'stock_unit' => 'kg',
            'point_per_weight' => 10,
            'weight_for_point' => 1000
        ]);
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


        $this->actingAs($this->user);
    }
    public function test_buy_without_promo()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 2,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(201);
        $this->assertEquals(98, $this->product->fresh()->stock);
    }

    // Path 2: Path Buy dengan promo
    public function test_buy_with_valid_promo()
    {
        $promo = Promo::factory()->create([
            'type_transaction' => 'Buy',
            'discount' => 10
        ]);

        $customerPromo = $this->customer->customerPromo()->create([
            'customer_id' => $this->customer->id,
            'promo_id' => $promo->id,
            'valid' => true
        ]);

        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 2,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => $customerPromo->id
        ]);

        $response->assertStatus(201);
        $this->assertEquals(90000, $response->json('data.total_price')); // 10% discount
    }

    // Path 3: Path Sell tanpa promo
    public function test_sell_without_promo()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Sell',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 2,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 80000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1020, $this->customer->fresh()->point); // Base points + earned points
    }
    public function test_required_fields_validation()
    {
        $response = $this->postJson('/transactions/store', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
                'product_id',
                'product_name',
                'quantity',
                'unit',
                'destination',
                'price'
            ]);
    }

    public function test_invalid_product_id_validation()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => 'not-a-number',
            'product_name' => 'Test Product',
            'quantity' => 1,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_product_not_found()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => 999999, // Non-existent product
            'product_name' => 'Test Product',
            'quantity' => 2,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function test_invalid_promo()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 2,
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => 99999 // Non-existent promo
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['customer_promo_id']);
    }

    public function test_insufficient_stock()
    {
        $response = $this->postJson('/transactions/store', [
            'title' => 'Buy',
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'quantity' => 101, // More than available stock
            'unit' => 'kg',
            'destination' => 'Test Address',
            'price' => 100000,
            'customer_promo_id' => null
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['quantity']);
    }
}
