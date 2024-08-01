<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Tasks\TaskController;
use App\Http\Controllers\Tasks\TaskReportController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', LogoutController::class)->name('logout');

    // Profile
    Route::get('/user', [ProfileController::class, 'userProfile'])->name('user-profile');
    Route::put('/user', [ProfileController::class, 'updateProfile'])->name('update-profile');

    // Tasks
    Route::get('/', [TaskController::class, 'userTasks'])->name('home');
    Route::get('/tasks', [TaskController::class, 'userTasks'])->name('user-tasks');
    Route::middleware(IsAdmin::class)->prefix('admin/')->group(function () {
        Route::apiResource('tasks', TaskController::class)->except('show');
        Route::get('/tasks/export/excel', [TaskReportController::class, 'exportTasksToExcel'])->name('tasks.export.excel');
        Route::get('/tasks/export/pdf', [TaskReportController::class, 'exportTasksToPdf'])->name('tasks.export.pdf');
        Route::post('/tasks/send-report', [TaskReportController::class, 'sendTaskReport'])->name('tasks.send-report');

        // Users
        Route::get('/users', UserController::class)->name('users.index');
    });
});
