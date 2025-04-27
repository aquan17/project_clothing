<?php


use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('web')->group(function () {
    // Route::get('cart', [CartController::class, 'index'])->name('cart');
    // Route::get('show', [ProductController::class, 'show'])->name('show');

    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::post('/products/{id}/review', [ProductController::class, 'submitReview'])->name('product.review');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/category/{id}', [ProductController::class, 'filterByCategory'])->name('client.category');

    Auth::routes();
});
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('cart.remove');
    // Route hiển thị trang checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.payment');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [UserController::class, 'profile'])->name('profile');
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders');
//     Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
// });