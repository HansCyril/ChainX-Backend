<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('dashboard', function() {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Customer Order History
Route::get('/orders', [App\Http\Controllers\OrderHistoryController::class, 'index'])
    ->middleware(['auth'])
    ->name('orders.index');

// Cart count endpoint (lightweight, for nav badge)
Route::get('/cart-count', function () {
    $cart = session()->get('cart', []);
    return response()->json(['count' => collect($cart)->sum('quantity')]);
});

Route::get('/wishlist-count', function () {
    if (!auth()->check()) return response()->json(['count' => 0]);
    return response()->json(['count' => \App\Models\Wishlist::where('user_id', auth()->id())->count()]);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);

    // Orders
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'update'])->name('orders.update');

    // Inventory
    Route::get('/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{product}', [\App\Http\Controllers\Admin\InventoryController::class, 'update'])->name('inventory.update');

    // Users
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/toggle-archive', [\App\Http\Controllers\Admin\UserController::class, 'toggleArchive'])->name('users.toggle-archive');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Reports
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');

    // Promo Codes
    Route::get('/promo-codes', [\App\Http\Controllers\Admin\PromoCodeController::class, 'index'])->name('promo-codes.index');
    Route::post('/promo-codes', [\App\Http\Controllers\Admin\PromoCodeController::class, 'store'])->name('promo-codes.store');
    Route::patch('/promo-codes/{promoCode}/toggle', [\App\Http\Controllers\Admin\PromoCodeController::class, 'toggle'])->name('promo-codes.toggle');
    Route::delete('/promo-codes/{promoCode}', [\App\Http\Controllers\Admin\PromoCodeController::class, 'destroy'])->name('promo-codes.destroy');

    // Riders
    Route::resource('riders', \App\Http\Controllers\Admin\RiderController::class);
    Route::patch('/riders/{rider}/toggle-status', [\App\Http\Controllers\Admin\RiderController::class, 'toggleStatus'])->name('riders.toggle-status');
});

// Storefront
Route::get('/products', \App\Livewire\ProductListing::class)->name('products.index');
Route::get('/cart', \App\Livewire\CartManager::class)->name('cart');
Route::get('/wishlist', \App\Livewire\WishlistManager::class)->middleware(['auth'])->name('wishlist');
Route::get('/checkout', \App\Livewire\Checkout::class)->middleware(['auth'])->name('checkout');
Route::get('/products/{product:slug}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

require __DIR__.'/auth.php';
