<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $orders = Order::with('items.productVariant.product')
            ->where('customer_id', $customer->id)
            ->where('status', 'pending') // Giỏ hàng chưa checkout
            ->latest()
            ->get();

        // Kiểm tra và in dữ liệu ra
        // dd($order->items->first());

        if (!$orders) {
            return redirect()->route('home')->with('error', 'Order not found');
        }

        return view('client.cart', compact('orders'));
    }


        // Thêm sản phẩm vào giỏ hàng
        public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $data = $request->only(['product_id', 'size', 'color', 'quantity']);

        // Tìm đơn hàng pending của người dùng
        $order = Order::where('customer_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            // Tạo đơn hàng mới nếu chưa có
            $order = Order::create([
                'customer_id' => Auth::id(),
                'status' => 'pending',
                'total_price' => 0, // Đúng: Dùng total_price
            ]);
        }

        // Tìm product variant dựa trên product_id, size và color
        $productVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'])
            ->where('color', $data['color'])
            ->first();

        if (!$productVariant) {
            return redirect()->back()->with('error', 'Không tìm thấy biến thể sản phẩm phù hợp!');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartItem = OrderItem::where('order_id', $order->id)
            ->where('product_variant_id', $productVariant->id)
            ->first();

        if ($cartItem) {
            // Nếu sản phẩm đã có, cập nhật số lượng
            $cartItem->quantity += $data['quantity'];
            $cartItem->save();
        } else {
            // Nếu chưa có, tạo mới OrderItem
            $cartItem = OrderItem::create([
                'order_id' => $order->id,
                'product_variant_id' => $productVariant->id,
                'quantity' => $data['quantity'],
                'price' => $productVariant->price,
            ]);
        }

        // Cập nhật tổng tiền của đơn hàng
        $order->total_price = $order->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });
        $order->save();

        return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
    }

    public function updateCart(Request $request, $cartItemId)
    {
        // Lấy mục giỏ hàng hiện tại
        $cartItem = OrderItem::findOrFail($cartItemId);
        $newQuantity = $request->input('quantity');
    
        // Kiểm tra nếu số lượng mới hợp lệ
        if ($newQuantity <= 0) {
            return response()->json(['message' => 'Số lượng không hợp lệ.'], 400);
        }
    
        // Tính lại giá trị của mục giỏ hàng
        $product = $cartItem->product;
        $totalItemPrice = $product->price * $newQuantity;
    
        // Cập nhật số lượng và tổng giá trị mục giỏ hàng
        $cartItem->quantity = $newQuantity;
        $cartItem->total_price = $totalItemPrice;
        $cartItem->save();
    
        // Cập nhật lại total_price của đơn hàng
        $order = $cartItem->order;
        $order->total_price = $order->orderItems()->sum('total_price');
        $order->save();
    
        return response()->json(['message' => 'Giỏ hàng đã được cập nhật.']);
    }
    

    
    
    public function update(Request $request, $id)
{
    $orderItem = OrderItem::findOrFail($id);

    // Nếu cần kiểm tra quyền
    // $this->authorize('update', $orderItem);

    // Validate quantity
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    // Cập nhật quantity
    $orderItem->quantity = $request->input('quantity');
    $orderItem->save();

    // Cập nhật total_price của Order
    $order = $orderItem->order;
    if ($order) {
        $order->load('items'); // Eager load quan hệ items
        $order->total_price = $order->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });
        $order->save();
    }

    return response()->json([
        'success' => true,
        'quantity' => $orderItem->quantity,
        'cartTotal' => $order ? $order->total_price : 0, // Trả về tổng tiền để đồng bộ giao diện
    ]);
}

    
public function remove($id)
{
    $item = OrderItem::findOrFail($id);

    // Nếu cần kiểm tra quyền
    // $this->authorize('delete', $item);

    $order = $item->order;
    $item->delete();

    // Cập nhật total_price của Order
    if ($order) {
        $order->load('items');
        $order->total_price = $order->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });
        $order->save();

        // Xóa Order nếu không còn OrderItem
        if ($order->items->isEmpty()) {
            $order->delete();
        }
    }

    return response()->json([
        'success' => true,
        'cartTotal' => $order ? $order->total_price : 0, // Trả về tổng tiền để đồng bộ giao diện
        'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng.'
    ]);
}
}
