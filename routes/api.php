<?php

use Illuminate\Support\Facades\Route;

// Authentication
use App\Http\Controllers\Api\AuthController;

// Public Resources
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PlantController;

// Customer Resources
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;

// Admin Resources
use App\Http\Controllers\Api\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC API ROUTES
|--------------------------------------------------------------------------
*/

// Home
Route::get('/home', [PlantController::class, 'index'])
    ->name('api.home');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])
    ->name('api.categories.index');

Route::get('/categories/{category}', [CategoryController::class, 'show'])
    ->name('api.categories.show');

// Plants
Route::get('/plants', [PlantController::class, 'index'])
    ->name('api.plants.index');

Route::get('/plants/{plant}', [PlantController::class, 'show'])
    ->name('api.plants.show');


/*
|--------------------------------------------------------------------------
| GUEST API ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('guest:api')->group(function () {

    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.register');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.login');

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATED API ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');

    Route::get('/me', [AuthController::class, 'me'])
        ->name('api.me');


    /*
    |--------------------------------------------------------------------------
    | CUSTOMER API ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:customer')
        ->prefix('customer')
        ->name('api.customer.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Customer Profile
            |--------------------------------------------------------------------------
            */

            Route::get('/profile', [ProfileController::class, 'show'])
                ->name('profile.show');

            Route::put('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');

            Route::put('/profile/password', [
                ProfileController::class,
                'updatePassword',
            ])->name('profile.password');


            /*
            |--------------------------------------------------------------------------
            | CART & CART ITEMS
            |--------------------------------------------------------------------------
            */

            Route::prefix('cart')->name('cart.')->group(function () {

                // View Cart
                Route::get('/', [CartController::class, 'index'])
                    ->name('index');

                // Add Plant to Cart
                Route::post('/items', [CartController::class, 'store'])
                    ->name('items.store');

                // Update Cart Item Quantity
                Route::put('/items/{cartItem}', [
                    CartController::class,
                    'update',
                ])->name('items.update');

                // Remove Cart Item
                Route::delete('/items/{cartItem}', [
                    CartController::class,
                    'destroy',
                ])->name('items.destroy');

                // Clear Cart
                Route::delete('/', [CartController::class, 'clear'])
                    ->name('clear');
            });


            /*
            |--------------------------------------------------------------------------
            | CHECKOUT
            |--------------------------------------------------------------------------
            */

            // Checkout Entire Cart
            Route::post('/checkout', [
                PaymentController::class,
                'checkoutCart',
            ])->name('checkout');

            // Buy Single Plant
            Route::post('/plants/{plant}/checkout', [
                PaymentController::class,
                'checkout',
            ])->name('plants.checkout');


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER ORDERS & ORDER ITEMS
            |--------------------------------------------------------------------------
            */

            // Order History
            Route::get('/orders', [OrderController::class, 'index'])
                ->name('orders.index');

            // Single Order with Order Items
            Route::get('/orders/{order}', [OrderController::class, 'show'])
                ->name('orders.show');


            /*
            |--------------------------------------------------------------------------
            | CUSTOMER PAYMENTS
            |--------------------------------------------------------------------------
            */

            // Payment Details
            Route::get('/orders/{order}/payment', [
                PaymentController::class,
                'show',
            ])->name('payments.show');

        });


    /*
    |--------------------------------------------------------------------------
    | ADMIN API ROUTES
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('api.admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Admin Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [
                DashboardController::class,
                'index',
            ])->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Admin Users
            |--------------------------------------------------------------------------
            */

            Route::get('/users', [AuthController::class, 'users'])
                ->name('users.index');


            /*
            |--------------------------------------------------------------------------
            | Admin Categories CRUD
            |--------------------------------------------------------------------------
            */

            Route::apiResource('categories', CategoryController::class);


            /*
            |--------------------------------------------------------------------------
            | Admin Plants CRUD
            |--------------------------------------------------------------------------
            */

            Route::apiResource('plants', PlantController::class);


            /*
            |--------------------------------------------------------------------------
            | ADMIN ORDERS & ORDER ITEMS
            |--------------------------------------------------------------------------
            */

            // All Orders
            Route::get('/orders', [OrderController::class, 'adminIndex'])
                ->name('orders.index');

            // Order Details and Items
            Route::get('/orders/{order}', [
                OrderController::class,
                'adminShow',
            ])->name('orders.show');

            // Update Order Status
            Route::put('/orders/{order}/status', [
                OrderController::class,
                'updateStatus',
            ])->name('orders.status');


            /*
            |--------------------------------------------------------------------------
            | ADMIN PAYMENTS
            |--------------------------------------------------------------------------
            */

            // All Payments
            Route::get('/payments', [
                PaymentController::class,
                'adminIndex',
            ])->name('payments.index');

            // Payment Details
            Route::get('/payments/{payment}', [
                PaymentController::class,
                'adminShow',
            ])->name('payments.show');


            /*
            |--------------------------------------------------------------------------
            | Admin Profile
            |--------------------------------------------------------------------------
            */

            Route::get('/profile', [ProfileController::class, 'show'])
                ->name('profile.show');

            Route::put('/profile', [ProfileController::class, 'update'])
                ->name('profile.update');

            Route::put('/profile/password', [
                ProfileController::class,
                'updatePassword',
            ])->name('profile.password');

        });

});


/*
|--------------------------------------------------------------------------
| PAYMENT CALLBACKS
|--------------------------------------------------------------------------
|
| Keep your existing SSLCOMMERZ callback routes in web.php.
| Do not duplicate them here if they are already registered there.
|
*/
