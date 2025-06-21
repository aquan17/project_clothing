<?php

use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\revenue\AdminRevenueController;
use App\Http\Controllers\Api\ProductApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;



Route::get('getRevenueData', [AdminRevenueController::class, 'getRevenueData'])->name('api.getRevenueData');


Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user,
    ]);
});
// Logout route
Route::post('/logout', function (Request $request) {
    // Xóa token hiện tại của user đang đăng nhập
    $request->user()->currentAccessToken()->delete();

    return response()->json(['message' => 'Logout successful']);
})->middleware('auth:sanctum');
// Sanctum protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/categories', [ProductApiController::class, 'create']);
    Route::get('/products/{id}', [ProductApiController::class, 'show']);
    Route::get('/products/{id}/edit', [ProductApiController::class, 'edit']);
    Route::put('/products/{id}', [ProductApiController::class, 'update']);
    Route::delete('/products/{id}', [ProductApiController::class, 'destroy']);

    Route::post('/products', [ProductApiController::class, 'store']);

    // Soft delete + trash management

});