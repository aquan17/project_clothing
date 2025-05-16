<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
        
        // 🛒 Chặn truy cập checkout nếu chưa có đơn hàng ở trạng thái cart
       // ❌ Không lưu nếu là request AJAX hoặc phương thức POST
        if (!$request->ajax() && $request->method() === 'GET') {

            // ❌ Không lưu nếu là route login/logout/register
            $excludedRoutes = [
                'client.login', 'client.login.submit',
                'client.register', 'client.logout'
            ];

            if (!in_array(Route::currentRouteName(), $excludedRoutes)) {
                session(['url.intended' => $request->fullUrl()]);
            }
        }

        return $next($request);
    }
}
