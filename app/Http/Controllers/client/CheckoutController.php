<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Hiển thị thông tin giỏ hàng và trang thanh toán
    public function index()
    {
        // Lấy giỏ hàng của khách hàng
        $cart = Cart::where('customer_id', Auth::user()->customer->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống');
        }

        // Lấy các mặt hàng trong giỏ hàng
        $cartItems = $cart->items;

        // Tính tổng tiền
        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        // Lấy danh sách địa chỉ của khách hàng
        $addresses = ShippingAddress::where('customer_id', Auth::user()->customer->id)->get();

        return view('client.checkout', compact('cartItems', 'total', 'addresses'));
    }

    public function processPayment(Request $request)
    {
        // Validate dữ liệu từ form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'country' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'order_notes' => 'nullable|string',
            'is_default' => 'nullable|boolean',
            'shipping_option' => 'required|in:free_shipping,flat,local_pickup',
            'payment_option' => 'required|in:direct_bank_transfer,check_payments,cash_on_delivery,paypal',
            'terms_condition' => 'accepted',
        ]);

        // Lấy giỏ hàng
        $cart = Cart::where('customer_id', Auth::user()->customer->id)->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống');
        }

        // Tính tổng tiền
        $total = $cart->items->sum(fn($item) => $item->price * $item->quantity);

        // Tính phí vận chuyển
        $shippingFee = match ($request->shipping_option) {
            'free_shipping' => 0,
            'flat' => 12000,
            'local_pickup' => 0,
            default => 0,
        };

        // Lưu địa chỉ giao hàng
        if ($request->is_default) {
            ShippingAddress::where('customer_id', Auth::user()->customer->id)
                ->update(['is_default' => false]);
        }

        $address = ShippingAddress::create([
            'customer_id' => Auth::user()->customer->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'country' => $request->country,
            'province' => $request->province,
            'district' => $request->district,
            'ward' => $request->ward,
            'street' => $request->street,
            'notes' => $request->notes,
            'is_default' => $request->is_default ?? false,
        ]);

        // Tạo đơn hàng
        $order = Order::create([
            'customer_id' => Auth::user()->customer->id,
            'shipping_address_id' => $address->id,
            'total_price' => $total,
            'shipping_fee' => $shippingFee,
            'status' => 'pending',
            'payment_method' => $request->payment_option,
            'payment_status' => 'unpaid',
            'notes' => $request->order_notes,
        ]);

        // Lưu các mặt hàng từ giỏ hàng vào order_items
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkout.success', $order->id)
            ->with('success', 'Đặt hàng thành công!');
    }

    public function success(Order $order)
    {
        // Đảm bảo đơn hàng thuộc về khách hàng
        if ($order->customer_id !== Auth::user()->customer->id) {
            abort(403, 'Không có quyền truy cập');
        }

        return view('client.checkout_success', compact('order'));
    }
}
