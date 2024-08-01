<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_profile(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('user-profile'));

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]);
    }

    public function test_user_profile_unauthenticated(): void
    {
        $response = $this->getJson(route('user-profile'));
        $response->assertStatus(401);
    }
}
