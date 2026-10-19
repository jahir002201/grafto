<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('home/plants/{plant}', [HomeController::class, 'show'])->name('home.plants.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::resource('categories', CategoryController::class);
    Route::resource('plants', PlantController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Dashboard profile
    Route::prefix('dashboard/profile')->name('dashboard.profile.')->group(function () {
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('update-password');
    });

    // Home profile
    Route::prefix('home/profile')->name('home.profile.')->group(function () {
        Route::get('/show', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/password', [ProfileController::class, 'password'])->name('password');
        Route::put('/password', [ProfileController::class, 'updatePassword'])
            ->name('update-password');
    });
});