<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get recent orders with related data
        // Get recent orders with relationships and aggregate data
        $recentOrders = Order::with(['customer.user', 'items'])
        ->latest()
        ->take(5)
        ->get()
        ->map(function ($order) {
            $order->status_color = $this->getStatusColor($order->status);
            $order->items_count = $order->items->count();
            return $order;
        });
            $topProducts = Product::where('buyer_count', '>', 0)
        ->orderByDesc('buyer_count')
        ->take(5)
        ->get()
        ->map(function ($product) {
             $revenue = $product->price * $product->buyer_count;  // Tính doanh thu
            return [
                // 'id' => $product->id,
                'created_at' => $product->created_at->format('d/m/Y'),
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'total_stock' => $product->total_stock,
                'buyer_count' => $product->buyer_count,
                      'revenue' => $revenue,  // Thêm doanh thu vào kết quả
                'url' => route('admin.products.show', $product->id),
            ];
        });
// dd($topProducts);
    return view('admin.Dashboard', compact('recentOrders','topProducts'));
    }

    private function getStatusColor($status)
    {
       switch ($status) {
        case 'pending':
            return 'warning';
        case 'processing':
            return 'info';
        case 'shipped':
            return 'primary';
        case 'delivered':
            return 'success';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
    }
}
