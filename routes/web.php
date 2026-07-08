<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;

Route::resource('categories', CategoryController::class);
Route::resource('plants', PlantController::class);