<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskStoreRequest;
use App\Http\Requests\Tasks\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TaskController extends Controller
{
    public function index(): JsonResponse
    {
        $tasks = Auth::user()->tasks()->with('subtasks', 'dependencies', 'notifications')->get();
        return Response::json($tasks);
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $task = Auth::user()->tasks()->create($request->validated());
        return Response::json($task, 201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorize('view', $task);
        return Response::json($task->load('subtasks', 'dependencies', 'notifications'));
    }

    public function update(TaskUpdateRequest $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);
        $task->update($request->all());
        return Response::json($task);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();
        return Response::json(['message' => 'Task deleted successfully']);
    }
}
