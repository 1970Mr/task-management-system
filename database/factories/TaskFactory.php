<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'description' => fake()->paragraph,
            'priority' => fake()->randomElement(TaskPriority::values()),
            'status' => fake()->randomElement(TaskStatus::values()),
            'deadline' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'user_id' => User::factory(),
            'parent_task_id' => null,
        ];
    }
}
