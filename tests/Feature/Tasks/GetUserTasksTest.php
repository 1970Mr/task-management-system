<?php

namespace Tests\Feature\Tasks;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetUserTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_user_tasks(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        Task::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('user-tasks'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'priority',
                        'status',
                        'deadline',
                        'users',
                    ],
                ],
                'meta' => [
                    'count'
                ]
            ]);
    }

    public function test_get_user_tasks_unauthenticated(): void
    {
        $response = $this->getJson(route('user-tasks'));
        $response->assertStatus(401);
    }
}
