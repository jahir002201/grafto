<?php

use Illuminate\Support\Facades\Route;

// API Controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PlantController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

// Public Home
Route::get('/home', [PlantController::class, 'index']);

// Public Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// Public Plants
Route::get('/plants', [PlantController::class, 'index']);
Route::get('/plants/{plant}', [PlantController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Guest API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.login');

});


/*
|--------------------------------------------------------------------------
| Authenticated API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);


    /*
    |--------------------------------------------------------------------------
    | Customer API Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('api.customer.')
        ->group(function () {

            // Customer Profile
            Route::get('/profile', [ProfileController::class, 'show'])
                ->name('profile.show');

            Route::put('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');

            Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
                ->name('profile.password');

            // Plant Checkout
            Route::post('/plants/{plant}/checkout', [
                PaymentController::class,
                'checkout',
            ])->name('plants.checkout');

        });


    /*
    |--------------------------------------------------------------------------
    | Admin API Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('api.admin.')
        ->group(function () {

            // Admin Dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            // Users
            Route::get('/users', [AuthController::class, 'users'])
                ->name('users');

            // Categories CRUD
            Route::apiResource('categories', CategoryController::class);

            // Plants CRUD
            Route::apiResource('plants', PlantController::class);

            // Admin Profile
            Route::get('/profile', [ProfileController::class, 'show'])
                ->name('profile.show');

            Route::put('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');

            Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
                ->name('profile.password');

        });

});