<?php

namespace App\Http\Requests\Tasks;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:' . $priorities,
            'status' => 'required|in:' . $statuses,
            'deadline' => 'required|date',
            'parent_task_id' => 'nullable|exists:tasks,id',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ];
    }
}
