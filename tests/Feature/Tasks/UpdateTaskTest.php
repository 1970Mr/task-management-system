<?php

namespace Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Events\TaskCreated;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_task_successful(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user, ['*']);

        $taskData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'priority' => TaskPriority::Medium,
            'status' => TaskStatus::Completed,
            'deadline' => now()->addWeek(),
            'user_ids' => [$user->id],
        ];

        $response = $this->putJson(route('tasks.update', $task->id), $taskData);

        $response->assertStatus(200)
            ->assertJsonStructure(['title', 'description', 'priority', 'status', 'deadline', 'users']);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    public function test_update_task_validation_error(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create(['user_id' => $user->id]);
        Sanctum::actingAs($user, ['*']);

        $response = $this->putJson(route('tasks.update', $task->id), [
            'title' => null,
            'priority' => 'invalid-priority',
            'status' => 'invalid-status',
            'deadline' => 'invalid-deadline',
        ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'priority', 'status', 'deadline']);
    }

    public function test_update_task_authorization_error(): void
    {
        $user = User::factory()->create();
        $adminUser = User::factory()->create(['role' => UserRole::Admin]);
        $task = Task::factory()->create(['user_id' => $adminUser->id]);
        Sanctum::actingAs($user);

        $response = $this->putJson(route('tasks.update', $task->id), []);
        $response->assertStatus(403);
    }
}
