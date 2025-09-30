<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


//routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

//userprofile
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'profile']);
//update profile
Route::middleware('auth:sanctum')->put('/user', [UserController::class, 'updateProfile']);
//change password
Route::middleware('auth:sanctum')->put('/user/change-password', [UserController::class, 'changePassword']);
//logout
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);

//test route
Route::get('/test-api', function() {
    return 'API route is working!';
});