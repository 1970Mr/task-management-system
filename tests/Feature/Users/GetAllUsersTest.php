<?php

namespace Tests\Feature\Users;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetAllUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_users(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        User::factory()->count(3)->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('tasks.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                        'role',
                    ],
                ],
                'meta' => [
                    'count'
                ]
            ]);
    }

    public function test_get_all_users_unauthenticated(): void
    {
        $response = $this->getJson(route('users.index'));
        $response->assertStatus(401);
    }
}
