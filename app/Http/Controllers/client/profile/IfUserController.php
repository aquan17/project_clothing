<?php

namespace App\Http\Controllers\client\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Wishlist;

class IfUserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        $customer = $user->customer;
        $wishlists = $customer->wishlists()->with(['product.category'])->get();
        $shippingAddresses = $customer->shippingAddresses;
        $orders = $customer->orders()
            ->with(['items.productVariant.product.category', 'shippingAddress'])
            ->where('status', '!=', 'cart')  // Lọc luôn trong query
            ->get();
        $processingOrders = $orders->where('status', 'pending');
        $shippingOrders = $orders->where('status', 'confirmed');
        $completedOrders = $orders->where('status', 'completed');
        $cancelledOrders = $orders->where('status', 'cancelled');
        return view('client.profile.info', compact('user', 'customer', 'orders', 'wishlists', 'shippingAddresses', 'processingOrders', 'shippingOrders', 'completedOrders', 'cancelledOrders'));
    }

    public function getInvoiceDetails($orderId)
    {
        try {
            // Lấy thông tin đơn hàng với các quan hệ cần thiết
            $order = Order::with(['items', 'items.productVariant', 'items.productVariant.product', 'shippingAddress'])
                ->findOrFail($orderId);

            // Xử lý địa chỉ giao hàng
            $shippingAddress = $order->shippingAddress ?? (object) [
                'name' => 'N/A',
                'phone' => 'N/A',
                'country' => 'N/A',
                'province' => 'N/A',
                'district' => 'N/A',
                'ward' => 'N/A',
                'is_default' => false, // thêm dòng này
            ];

            // Lấy danh sách sản phẩm trong đơn hàng
            $items = $order->items->map(function ($item) {
                return [
                    'product_name' => $item->productVariant->product->name ?? 'Unknown Product',
                    'quantity' => $item->quantity,
                    'price' => (float) ($item->productVariant->price ?? 0), // Lấy giá từ product_variants
                ];
            });

            // Tính subtotal từ giá trong product_variants
            $subtotal = $order->items->sum(function ($item) {
                return ($item->price ?? 0) * $item->quantity;
            });
            // dd($subtotal);
            // Lấy giá trị discount (voucher_discount), shipping và tính total`
            $discount = (float) ($order->voucher_discount ?? 0);
            $shipping = (float) ($order->shipping_fee ?? 0);
            $total = $subtotal + $shipping - $discount;
            // dd($discount);
            // Trả về view với dữ liệu
            return view('client.profile.order_details', [
                'order' => $order,
                'shippingAddress' => $shippingAddress,
                'items' => $items,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Không thể tải chi tiết đơn hàng');
        }
    }
    public function cancelled($id)
    {
        $order = Order::findOrFail($id);

        // Chỉ cho phép hủy đơn hàng nếu trạng thái là pending
        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();

            // Thực hiện các hành động cần thiết như hoàn tiền, nếu có
            // Ví dụ: $this->refund($order);

            return redirect()->route('client.profile')->with('status', 'Your order has been cancelled.');
        }

        return redirect()->route('orders.index')->with('error', 'You can only cancel orders that are pending.');
    }
}
