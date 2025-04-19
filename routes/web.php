<?php


use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('cart',[CartController::class,'index'])->name('cart');
Route::get('show',[ProductController::class,'show'])->name('show');
Route::get('checkout',[CheckoutController::class,'index'])->name('checkout');
Route::resource('products', ProductController::class)->only(['index', 'show']);

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

// Đánh giá sản phẩm
Route::post('/products/{id}/review', [ProductController::class, 'submitReview'])->name('product.review');

// Tìm kiếm sản phẩm
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// lọc sản phẩm theo danh mục
// Route::get('/category/{id}', [HomeController::class, 'filterByCategory'])->name('client.category');
Route::get('/category/{id}', [ProductController::class, 'filterByCategory'])->name('client.category');  

Auth::routes();

