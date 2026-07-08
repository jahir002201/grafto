<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PlantController;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('plants', PlantController::class);

// use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\CategoryController;
// use App\Http\Controllers\Api\PlantController;


// Route::prefix('auth')->group(function () {

//     Route::post('register', [AuthController::class,'register']);

//     Route::post('login', [AuthController::class,'login']);

//     Route::post('logout', [AuthController::class,'logout']);

//     Route::post('refresh', [AuthController::class,'refresh']);

// });

// Route::apiResource('categories', CategoryController::class);

// Route::apiResource('plants', PlantController::class);
