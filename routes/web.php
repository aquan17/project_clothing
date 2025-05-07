<?php

use App\Http\Controllers\client\AddressController;
use App\Http\Controllers\client\profile\IfUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\client\PaymentController;
use App\Http\Controllers\client\ProductController;
use App\Http\Controllers\client\UserController;
use App\Http\Controllers\client\VoucherController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('/test-order-info', function () {
//     $fakeOrder = [
//         'defaultAddress' => \App\Models\ShippingAddress::first(),
//         'finalTotal' => 500000,
//         'subtotal' => 500000,
//         'voucherDiscount' => 50000,
//         'shippingFee' => 20000,
//         'coupon_id' => 1,
//         'notes' => 'Đơn hàng test',
//         'selectedItems' => collect([
//             (object)[
//                 'product_variant_id' => 1,
//                 'quantity' => 2,
//                 'price' => 150000,
//             ],
//             (object)[
//                 'product_variant_id' => 2,
//                 'quantity' => 1,
//                 'price' => 200000,
//             ],
//         ]),
//     ];

//     Session::put('order_info', $fakeOrder);
//     Session::save(); // <- rất quan trọng
//     Log::info('Dữ liệu order_info đã được lưu vào session:', ['order_info' => $fakeOrder]);

//     // Kiểm tra session
//     Log::debug('Dữ liệu trong session:', [Session::get('order_info')]);
//     return redirect()->route('client.payment.showPaymentPage');
// });
Route::get('/', [HomeController::class, 'index'])->name('client.home');

Route::middleware('web')->group(function () {
    Route::resource('products', ProductController::class)->only(['index', 'show'])->names([
        'index' => 'client.products',
        'show' => 'client.products.show',
    ]);

    Route::get('/search', [ProductController::class, 'search'])->name('client.products.search');
    Route::get('/category/{id}', [ProductController::class, 'filterByCategory'])->name('client.category');
    Route::post('/products/{id}/review', [ProductController::class, 'submitReview'])->name('client.products.review');
    Route::get('/profile', [UserController::class, 'profile'])->name('client.profile');
    Auth::routes(); // Login/Register
});

/*
|--------------------------------------------------------------------------
| Client Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
Route::middleware(['auth', 'preventDirectAccess'])->group(function () {
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
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Optional: Profile, Orders, Wishlist
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [UserController::class, 'profile'])->name('client.profile');
//     Route::get('/orders', [OrderController::class, 'index'])->name('client.orders');
//     Route::get('/wishlist', [WishlistController::class, 'index'])->name('client.wishlist');
// });
