<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventDirectAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        // 🛒 Chặn truy cập checkout nếu chưa có đơn hàng ở trạng thái cart
        if (in_array($routeName, ['client.checkout', 'client.checkout.process'])) {
            if (!Auth::check()) {
                return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
            }

            $order = Order::where('customer_id', Auth::id())
                          ->where('status', 'cart')
                          ->first();

            if (!$order || $order->orderItems->isEmpty()) {
                return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
            }
        }

        // ✅ Chặn confirmation nếu không có đơn hàng đã đặt
        // if ($routeName === 'client.confirmation') {
        //     $orderId = $request->route('order'); // nếu route là /confirmation/{order}
        //     $order = Order::find($orderId);

        //     if (!$order || $order->customer_id !== Auth::id() || $order->status === 'cart') {
        //         return redirect()->route('client.home')->with('error', 'Trang không tồn tại hoặc bạn không có quyền truy cập.');
        //     }
        // }

        // 📦 Chặn truy cập cart nếu chưa có đơn hàng cart
        if ($routeName === 'client.cart') {
            if (!Auth::check()) {
                return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
            }

            $order = Order::where('customer_id', Auth::id())->where('status', 'cart')->first();
            if (!$order) {
                return redirect()->route('client.home')->with('error', 'Giỏ hàng trống.');
            }
        }

        // 🛍️ Nếu muốn: chặn truy cập trực tiếp vào trang products (danh sách) nếu chưa login
        // if ($routeName === 'client.products') {
        //     if (!Auth::check()) {
        //         return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để xem sản phẩm.');
        //     }
        // }

        return $next($request);
    }
}
