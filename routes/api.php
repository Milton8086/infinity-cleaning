<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/test-api', function() {
    return 'API routes are loaded!';
});


// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (requires auth:sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'update']);
});
