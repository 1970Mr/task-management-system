<?php

namespace App\Http\Requests\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $priorities = implode(',', TaskPriority::values());
        $statuses = implode(',', TaskStatus::values());
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'sometimes|in:' . $priorities,
            'status' => 'sometimes|in:' . $statuses,
            'deadline' => 'sometimes|date',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'user_ids' => 'sometimes|array',
            'user_ids.*' => 'required_with::user_ids|exists:users,id',
        ];
    }
}
