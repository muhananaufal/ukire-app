<?php

use App\Http\Controllers\Auth\GoogleLoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaticPageController;
use App\Livewire\Catalog;
use App\Livewire\OrderHistory;
use App\Livewire\ShoppingCart;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Public Routes (Accessible by Everyone)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/catalog', Catalog::class)->name('catalog.index');
Route::get('/product/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Static Pages
Route::get('/pages/{slug}', [StaticPageController::class, 'show'])->name('static.page');

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
    // History
    Route::get('/order-history', OrderHistory::class)->name('order.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/invoices/{order}', [InvoiceController::class, 'download'])->name('invoice.download');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart Management
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', ShoppingCart::class)->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::patch('/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/{item}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout Process
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/orders/{order}/pay', [CheckoutController::class, 'retryPayment'])->name('order.pay');
});

// Breeze Auth Routes (login, register, etc.)
require __DIR__ . '/auth.php';
