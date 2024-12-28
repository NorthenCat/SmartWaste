<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthControllerTest extends TestCase
{

    /**
     * Test for successful registration
     */
    public function test_registration_successful(): void
    {
        $response = $this->post('/auth/register', [
            'first_name' => 'User',
            'last_name' => 'Test',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect('/auth');
    }

    /**
     * Test for successful login
     */

    public function test_login_successful(): void
    {

        $response = $this->post('/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
    }

}
