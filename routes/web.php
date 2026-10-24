<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

// Public home pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/home/plants/{plant}', [HomeController::class, 'show'])
    ->name('home.plants.show');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    // ADMIN ONLY
    Route::middleware('role:admin')
        ->prefix('dashboard')
        ->name('dashboard.')
        ->group(function () {

            Route::get('/', [DashboardController::class, 'index'])
                ->name('index');

            Route::resource('categories', CategoryController::class);
            Route::resource('plants', PlantController::class);

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/show', [ProfileController::class, 'show'])
                    ->name('show');

                Route::get('/edit', [ProfileController::class, 'edit'])
                    ->name('edit');

                Route::put('/update', [ProfileController::class, 'update'])
                    ->name('update');

                Route::get('/password', [ProfileController::class, 'password'])
                    ->name('password');

                Route::put('/password', [ProfileController::class, 'updatePassword'])
                    ->name('update-password');
            });
        });

    // CUSTOMER ONLY
    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('customer.')
        ->group(function () {

            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/show', [ProfileController::class, 'show'])
                    ->name('show');

                Route::get('/edit', [ProfileController::class, 'edit'])
                    ->name('edit');

                Route::put('/update', [ProfileController::class, 'update'])
                    ->name('update');

                Route::get('/password', [ProfileController::class, 'password'])
                    ->name('password');

                Route::put('/password', [ProfileController::class, 'updatePassword'])
                    ->name('update-password');
            });
        });
});

// Customer must be logged in to purchase a plant.
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::post('/plants/{plant}/checkout', [
        PaymentController::class,
        'checkout',
    ])->name('payment.plant.checkout');
});

// SSLCOMMERZ callbacks.
// These routes must be publicly reachable by the gateway.
Route::post('/payment/success', [
    PaymentController::class,
    'success',
])->name('payment.success');

Route::post('/payment/fail', [
    PaymentController::class,
    'fail',
])->name('payment.fail');

Route::post('/payment/cancel', [
    PaymentController::class,
    'cancel',
])->name('payment.cancel');

Route::post('/payment/ipn', [
    PaymentController::class,
    'ipn',
])->name('payment.ipn');