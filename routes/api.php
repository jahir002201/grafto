<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\DashboardController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('plants', PlantController::class)->only(['index', 'show']);

Route::middleware('auth:api')->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::get('users', [AuthController::class, 'users']);

    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('plants', PlantController::class)->except(['index', 'show']);

    Route::get('dashboard', [DashboardController::class, 'index']);
});