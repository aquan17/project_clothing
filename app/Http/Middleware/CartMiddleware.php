<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Middleware ShareCartItems is running');
        $cartItems = collect();         // Tất cả sản phẩm trong giỏ
        $cartMiniItems = collect();     // 2 sản phẩm mới nhất hiển thị
        $cartTotal = 0;                 // Tổng giá trị toàn bộ giỏ hàng

        if (Auth::check()) {
            // Log::info('User is authenticated', ['user_id' => Auth::id()]);
            $customer = Customer::where('user_id', Auth::id())->first();

            if ($customer) {
                // Log::info('Customer found', ['customer_id' => $customer->id]);

                // Lấy đơn hàng với tất cả items
                $order = Order::with(['items.productVariant.product'])
                    ->where('customer_id', $customer->id)
                    ->where('status', 'cart') // Giả sử giỏ hàng là 'pending'
                    ->latest()
                    ->first();
                // dd($customer);
                // dd($order);
                if ($order) {
                    Log::info('Order found', ['order_id' => $order->id]);
                    // Gán tất cả sản phẩm vào biến chính
                    $cartItems = $order->items ?? collect([]);
                    // dd($cartItems);
                    // Lấy 2 sản phẩm mới nhất để hiển thị mini cart
                    $cartMiniItems = $cartItems->sortByDesc('created_at')->take(6)->values();
                    // Tính tổng giá trị toàn bộ giỏ hàng
                    $cartTotal = $cartItems->sum(function ($item) {
                        return $item->productVariant->product->price * $item->quantity;
                    });
                } else {
                    Log::info('No pending order found for customer');
                }
            } else {
                Log::info('Customer not found for user');
            }
        } else {
            // Log::info('User is not authenticated');
        }

        // Đảm bảo $cartItems luôn là Collection
        // Log::info('Cart Items', ['cartItems' => $cartItems->toArray()]);
        // Log::info('Cart Total', ['cartTotal' => $cartTotal]);
        $query = Product::query();

        if ($request->has('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

       

        $categoriesGrouped = Category::withCount('products')->get()->groupBy('group');


        // Chia sẻ ra tất cả view
        View::share('categoriesGrouped', $categoriesGrouped); // Danh sách danh mục
        View::share('cartItems', $cartItems);           // Tất cả sản phẩm
        View::share('cartMiniItems', $cartMiniItems);   // 2 sản phẩm hiển thị
        View::share('cartTotal', $cartTotal);           // Tổng giá trị giỏ hàng

        return $next($request);
    }
}
