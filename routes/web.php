<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
});

Route::get('/products', \App\Livewire\ProductListing::class)->name('products.index');
Route::get('/cart', \App\Livewire\CartManager::class)->name('cart');
Route::get('/wishlist', \App\Livewire\WishlistManager::class)->middleware(['auth'])->name('wishlist');
Route::get('/checkout', \App\Livewire\Checkout::class)->middleware(['auth'])->name('checkout');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

require __DIR__.'/auth.php';
