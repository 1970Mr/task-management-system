<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Tasks\TaskReportController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', LogoutController::class);

    // Profile
    Route::get('/user', [ProfileController::class, 'userProfile']);
    Route::put('/user', [ProfileController::class, 'updateProfile']);

    // Tasks
    Route::get('/', [TaskController::class, 'userTasks']);
    Route::get('/tasks', [TaskController::class, 'userTasks']);
    Route::middleware(IsAdmin::class)->prefix('admin/')->group(function () {
        Route::apiResource('tasks', TaskController::class);
        Route::get('/tasks/export/excel', [TaskReportController::class, 'exportTasksToExcel']);
        Route::get('/tasks/export/pdf', [TaskReportController::class, 'exportTasksToPdf']);
        Route::post('/tasks/send-report', [TaskReportController::class, 'sendTaskReport']);
    });
});
