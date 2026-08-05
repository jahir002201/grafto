<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterController::class, 'create'])->name('register');

    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    Route::get('/login', [LoginController::class, 'create'])->name('login');

    Route::post('/login', [LoginController::class, 'store'])->name('login');

});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('categories', CategoryController::class);
    Route::resource('plants', PlantController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/profile/show', [ProfileController::class, 'show'])->name('dashboard.profile.show');
    Route::get('/dashboard/profile/edit', [ProfileController::class, 'edit'])->name('dashboard.profile.edit');
    Route::put('/dashboard/profile/update', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::get('/dashboard/profile/password', [ProfileController::class, 'password'])->name('dashboard.profile.password');
    Route::put('/dashboard/profile/password', [ProfileController::class, 'updatePassword'])->name('dashboard.profile.update-password');
    });
