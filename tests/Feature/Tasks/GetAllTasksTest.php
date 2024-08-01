<?php

namespace Tasks;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetAllTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_tasks(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        Task::factory()->count(3)->create();
        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson(route('tasks.index'));

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

    public function test_get_all_tasks_unauthenticated(): void
    {
        $response = $this->getJson(route('tasks.index'));
        $response->assertStatus(401);
    }
}
