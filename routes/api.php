<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\AuthController;



Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout']);
Route::get('me', [AuthController::class, 'me']);
Route::get('users', [AuthController::class, 'users']);


Route::apiResource('categories', CategoryController::class);
Route::apiResource('plants', PlantController::class);