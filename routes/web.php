<?php

use App\Http\Controllers\admin\category\AdminCategoryController;
use App\Http\Controllers\admin\coupon\AdminCouponController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\order\AdminOrderController;
use App\Http\Controllers\admin\product\AdminProductController;
use App\Http\Controllers\admin\user\AdminUserController;
use App\Http\Controllers\client\AddressController;
use App\Http\Controllers\client\blog\BLogController;
use App\Http\Controllers\client\profile\IfUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\PaymentController;
use App\Http\Controllers\client\ProductController;
use App\Http\Controllers\client\UserController;
use App\Http\Controllers\client\VoucherController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('client.home');


Route::middleware('web')->group(function () {
    Route::resource('products', ProductController::class)->only(['index', 'show'])->names([
        'index' => 'client.products',
        'show' => 'client.products.show',
    ]);
// Route::get('/test-flash', function () {
//     session()->flash('success', 'Thông báo test flash thành công!');
//     return view('client.index'); // Hoặc view bạn dùng
// });
    Route::get('/search', [ProductController::class, 'search'])->name('client.products.search');
    Route::get('/category/{id}', [ProductController::class, 'filterByCategory'])->name('client.category');
    Route::post('/products/{id}/review', [ProductController::class, 'submitReview'])->name('client.products.review');
    Route::get('/profile', [UserController::class, 'profile'])->name('client.profile');
    Auth::routes(); // Login/Register
    // Blog
    Route::get('/about-us', [BLogController::class, 'about'])->name('client.blog.about');
    Route::get('/purchase-guide', [BLogController::class, 'purchase'])->name('client.blog.purchase');
    Route::get('/ecommerce-faq', [BLogController::class, 'ecommerce'])->name('client.blog.ecommerce');
    Route::get('/privacy-policy', [BLogController::class, 'privacy'])->name('client.blog.privacy');
    Route::get('/terms-conditions', [BLogController::class, 'terms'])->name('client.blog.terms');
    Route::get('/contact', [BLogController::class, 'contact'])->name('client.blog.contact');
});

/*
|--------------------------------------------------------------------------
| Client Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
Route::middleware(['auth'])->group(function () {
    // 🛒 Cart
    Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('client.cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'remove'])->name('client.cart.remove');
    Route::delete('cart/clear', [CartController::class, 'clearCart'])->name('client.cart.clear');

    // 💳 Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('client.checkout.index');

    // 💳 Payment
    Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('client.payment.showPaymentPage');
    Route::post('/payment/cod', [PaymentController::class, 'handleCashOnDelivery'])->name('client.payment.handleCashOnDelivery');
    Route::get('/payment/success/{orderCode}', [PaymentController::class, 'success'])->name('client.confirmation');

    // 🎟️ Voucher
    Route::post('/voucher/apply', [VoucherController::class, 'applyVoucher'])->name('client.voucher.apply');
    Route::post('/voucher/remove', [VoucherController::class, 'removeVoucher'])->name('client.voucher.remove');

    Route::resource('address', AddressController::class);
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');

    Route::get('/profile', [IfUserController::class, 'profile'])->name('client.profile');
    Route::get('/order/invoice/{order}', [IfUserController::class, 'getInvoiceDetails'])->name('client.profile.invoice');
    Route::get('/profile/cancelled/{id}', [IfUserController::class, 'cancelled'])->name('client.profile.cancelled');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['web', 'auth', 'admin']) // Sử dụng middleware theo cách chuẩn
    ->group(function () {
        // Route cho trang dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // Resource route cho sản phẩm
        Route::resource('products', AdminProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);

        // Route phục hồi sản phẩm đã xóa (soft delete)
        Route::get('/products/restore/{id}', [AdminProductController::class, 'restore'])->name('admin.products.restore');
        
        // Route xóa sản phẩm vĩnh viễn (force delete)
        Route::delete('/products/force-delete/{id}', [AdminProductController::class, 'forceDelete'])->name('admin.products.forceDelete');

        // Route cho đơn hàng
            Route::resource('orders', AdminOrderController::class)->names([
                'index' => 'admin.orders.index',
                'create' => 'admin.orders.create',
                'store' => 'admin.orders.store',
                'show' => 'admin.orders.show',
                'edit' => 'admin.orders.edit',
                'update' => 'admin.orders.update',
                'destroy' => 'admin.orders.destroy',
            ]);
        Route::get('admin/orders/data', [AdminOrderController::class, 'getOrdersData'])->name('admin.orders.data');
        Route::resource('users', AdminUserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        Route::get('admin/users/data', [AdminUserController::class, 'getUsersData'])->name('admin.users.data');
    });
    // Route cho Category
    Route::resource('categories', AdminCategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'show' => 'admin.categories.show',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    // Route cho coupon
    
    Route::resource('coupons', AdminCouponController::class)->names([
        'index' => 'admin.coupons.index',
        'create' => 'admin.coupons.create',
        'store' => 'admin.coupons.store',
        'show' => 'admin.coupons.show',
        'edit' => 'admin.coupons.edit',
        'update' => 'admin.coupons.update',
        'destroy' => 'admin.coupons.destroy',
    ]);
// Test route for PUT request
    Route::put('/test-update/{id}', function ($id) {
        return response()->json(['message' => 'PUT request successful', 'id' => $id]);
    });
    