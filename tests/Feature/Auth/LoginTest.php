<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_successful(): void
    {
        $user = User::factory()->create([
            'password' => $password = 'password'
        ]);

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type',]);
    }

    public function test_login_failed(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid login details']);
    }
}
