<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Public Routes (Accessible by Everyone)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/product/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Static Pages
Route::get('/pages/{slug}', [StaticPageController::class, 'show'])->name('static.page');

// Cart Management
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'store'])->name('store');
    Route::patch('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'destroy'])->name('destroy');
});

// Google Auth Routes
Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Requires User to be Logged In)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout Process
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/orders/{order}/pay', [CheckoutController::class, 'retryPayment'])->name('order.pay');
});

// Breeze Auth Routes (login, register, etc.)
require __DIR__ . '/auth.php';