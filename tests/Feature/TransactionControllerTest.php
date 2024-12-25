<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Artisan;

class TransactionControllerTest extends TestCase
{

    /**
     * Test the indexBuy view is returned.
     */
    public function test_index_buy_view_is_returned(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate clicking the "Buy" button
        $response = $this->get('/transactions/buy');

        $response->assertStatus(200);
        $response->assertViewIs('customers.transactions.index');
        $response->assertViewHas('title', 'Buy');
        $response->assertViewHas('products');
    }

    /**
     * Test the indexSell view is returned.
     */
    public function test_index_sell_view_is_returned(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simulate clicking the "Sell" button
        $response = $this->get('/transactions/sell');

        $response->assertStatus(200);
        $response->assertViewIs('customers.transactions.index');
        $response->assertViewHas('title', 'Sell');
        $response->assertViewHas('products');
    }

    /**
     * Test the create view is returned for Buy.
     */
    public function test_create_view_is_returned_for_buy(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        // Simulate clicking the "Buy" button
        $response = $this->get('/transactions/buy');

        $response = $this->get("/transactions/Buy/form/{$product->uuid}");

        $response->assertStatus(200);
        $response->assertViewIs('customers.transactions.form');
        $response->assertViewHas('product', $product);
    }

    /**
     * Test the create view is returned for Sell.
     */
    public function test_create_view_is_returned_for_sell(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        // Simulate clicking the "Sell" button
        $response = $this->get('/transactions/sell');

        $response = $this->get("/transactions/Sell/form/{$product->uuid}");

        $response->assertStatus(200);
        $response->assertViewIs('customers.transactions.form');
        $response->assertViewHas('product', $product);
    }
}