<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Profile\ProfileController;
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
});
