<?php

namespace App\Http\Controllers\admin\order;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShippingAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        // dd($orders);
        $pendingOrdersCount = $orders->where('status', 'pending')->count();
        // dd($pendingOrdersCount);
        $completedOrdersCount = $orders->where('status', 'completed')->count();
        // dd($completedOrdersCount);
        $confirmedOrdersCount = $orders->where('status', 'confirmed')->count();
        // dd($confirmedOrdersCount);
        $cancelledOrdersCount = $orders->where('status', 'cancelled')->count();
        $allOrdersCount = $orders->where('status')->count();

        $users = User::all();
        $products = Product::all();
        $shippingAddresses = ShippingAddress::all();
        $productVariants = ProductVariant::all();
        return view('admin.order.index', compact('orders', 'users', 'products', 'shippingAddresses', 'productVariants', 'pendingOrdersCount', 'completedOrdersCount', 'confirmedOrdersCount', 'cancelledOrdersCount', 'allOrdersCount'));
    }
    public function getOrdersData()
    {
       $orders = Order::with('customer.user', 'items.productVariant.product')
    ->where('status', '!=', 'cart')
    ->get();


        // Giản lược dữ liệu cho frontend
        $ordersData = $orders->map(function ($order) {
            $productVariantIds = $order->items->map(function ($item) {
                return $item->productVariant->id; // Lấy ID biến thể sản phẩm
            })->toArray();

            $productNames = $order->items->map(function ($item) {
                return $item->productVariant->product->name ?? 'N/A';
            })->join(', ');

            $quantities = $order->items->map(function ($item) {
                return $item->quantity;
            })->toArray();

            return [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'customer_id' => $order->customer_id, // Trả về ID khách hàng
               'customer_name' => $order->customer->user->name ?? 'Không có thông tin', // Lấy tên từ bảng users
                'product_variant_ids' => $productVariantIds, // Mảng ID biến thể sản phẩm
                'product_name' => $productNames, // Giữ tên để hiển thị

                'date' => $order->created_at->format('d M Y'),
                'amount' => '$' . number_format($order->total_price, 2),
                'payment' => $order->payment_method,
                'status' => $order->status,
                'shipping_address_id' => $order->shipping_address_id, // Thêm nếu có
                'quantities' => $quantities // Mảng số lượng
            ];
        });

        return response()->json($ordersData);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate dữ liệu
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_name' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_method' => 'required|in:Mastercard,Visa,COD,Paypal',
            'status' => 'required|string|max:255',
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'quantity' => 'required|numeric',
            'product_variant_id' => 'required|exists:product_variants,id',
        ]);
        Log::info('Order Store Request Data:', $request->all());
        do {
            $order_code = '#' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $order_code)->exists());
        // Tạo đơn hàng mới
        $order = Order::create([
            'order_code' => 'ORD' . time(),
            'customer_id' => $request->customer_name,
            'shipping_address_id' => $request->shipping_address_id,
            'total_price' => $request->amount,
            'created_at' => $request->date,
            'updated_at' => $request->date,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
        ]);
        // $product = Product::with('variants')->find($request->product_name);
        // $productVariant = $product->variants->first(); // Lấy biến thể đầu tiên


        $cartItems = OrderItem::create([
            'order_id' => $order->id,
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
            'price' => $request->amount,
        ]);
        Log::info('Order created:', $order->toArray());
        // Trả về kết quả
        return response()->json([
            'message' => 'Order added successfully!',
            'order' => $order,
            'cartItems' => $cartItems
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { $order = Order::with('items.productVariant.product') // Eager load các sản phẩm trong order
        ->where('id', $id)
        ->firstOrFail();
        $subtotal = $order->items->sum(function ($item) {
            return ($item->price ?? 0) * $item->quantity;
        });
        $discount = (float) ($order->voucher_discount ?? 0);
        $shipping = (float) ($order->shipping_fee ?? 0);
        $total = $subtotal + $shipping - $discount;
        return view('admin.order.show', compact('order', 'subtotal', 'discount', 'shipping', 'total'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = $request->input('status');
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete(); // hoặc soft delete nếu có
        return response()->json(['message' => 'Xóa thành công']);
    }
}
