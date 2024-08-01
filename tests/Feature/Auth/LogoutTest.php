<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_successful(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->post(route('logout'));
        $response->assertStatus(200)
            ->assertJson([ 'message' => 'Logged out successfully']);
    }

    public function test_logout_unauthenticated(): void
    {
        $response = $this->postJson(route('logout'));
        $response->assertStatus(401);
    }
}
