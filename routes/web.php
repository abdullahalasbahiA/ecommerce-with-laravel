<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProfileController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);
Route::get('/api/search', [ProductController::class, 'search']); // 🛠️ For JSON API
Route::get('/productsSearch', [ProductController::class, 'index']); // 📄 For the UI page


Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');


// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{payment}', [OrderController::class, 'show'])->name('orders.show');
});

Route::put('/admin/payments/{payment}/status', [OrderController::class, 'updateStatus'])
    ->name('payments.updateStatus');

Route::middleware(['auth', 'isAdminUser'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});



// Impletementing Cart functionalites
// Route::get('/', [ProductController::class, 'index'])->name('products.index');
// Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::post('/store-cart/{productId}', [CartController::class, 'store'])->name('cart.store');
Route::get('/fetch-cart', [CartController::class, 'jsonIndex'])->name('cart.index');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/store-cart/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/store-cart/{productId}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/something', function () {
    $products = Product::all();
    return view('products.something', compact('products'));
});

// Route::get('/', [ProductController::class, 'index']);
// Route::get('/products', [ProductController::class, 'index']); // 📄 For the UI page
// Route::get('/api/search', [ProductSearchController::class, 'searchApi'])->name('products.search.api');



// ==================================================
// ====================[ PayPal ]====================
// ==================================================
// Route::post('/paypal', [PaypalController::class, 'paypal'])->name('paypal');
Route::post('createpayment', [PaypalController::class, 'createPayment'])->name('createpayment')->middleware('auth');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('/cancel', [PaypalController::class, 'cancel'])->name('cancel');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
