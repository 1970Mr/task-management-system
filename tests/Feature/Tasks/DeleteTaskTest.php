<?php

namespace Tests\Feature\Tasks;

use App\Enums\UserRole;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_task_successful(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson(route('tasks.destroy', $task->id));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task deleted successfully',
            ]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_delete_task_not_found(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        Sanctum::actingAs($user, ['*']);
        $response = $this->deleteJson(route('tasks.destroy', 999));
        $response->assertStatus(404);
    }

    public function test_delete_task_authorization_error(): void
    {
        $user = User::factory()->create();
        $adminUser = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create(['user_id' => $adminUser->id]);
        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('tasks.destroy', $task->id));
        $response->assertStatus(403);
    }
}
