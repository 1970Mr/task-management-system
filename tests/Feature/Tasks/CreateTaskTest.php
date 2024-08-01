<?php

namespace Tests\Feature\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Enums\UserRole;
use App\Events\TaskCreated;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_successful(): void
    {
        Event::fake();

        $user = User::factory()->create(['role' => UserRole::Admin]);
        Sanctum::actingAs($user, ['*']);

        $taskData = [
            'title' => 'New Task',
            'description' => 'Task Description',
            'priority' => TaskPriority::Medium,
            'status' => TaskStatus::Active,
            'deadline' => now()->addWeek(),
            'user_ids' => [$user->id],
        ];

        $response = $this->postJson(route('tasks.store'), $taskData);

        $response->assertStatus(201)
            ->assertJsonStructure(['title', 'description', 'priority', 'status', 'deadline', 'users']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
        ]);

        Event::assertDispatched(TaskCreated::class);
    }

    public function test_create_task_validation_error(): void
    {
        $user = User::factory()->create(['role' => UserRole::Admin]);
        Sanctum::actingAs($user, ['*']);
        $response = $this->postJson(route('tasks.store'), []);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'priority', 'status', 'deadline', 'user_ids']);
    }

    public function test_create_task_authorization_error(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson(route('tasks.store'), []);
        $response->assertStatus(403);
    }
}
