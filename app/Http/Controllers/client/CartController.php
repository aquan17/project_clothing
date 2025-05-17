<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class CartController extends Controller
{
    public function index()
    {


        return view('client.cart');
    }
    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request)
    {
        // Kiểm tra nếu chưa đăng nhập
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!'
            ], 401); // Trả về lỗi 401 (Unauthorized)
        }
        do {
            $order_code = '#' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $order_code)->exists());
        // Tạo mã đơn hàng ngẫu nhiên
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);
        // dd($request->all());
 $customer = Customer::where('user_id', Auth::id())->first();
        $data = $request->only(['product_id', 'size', 'color', 'quantity']);
        // Tìm đơn hàng pending của người dùng
        $order = Order::where('customer_id', $customer->id)
        ->where('status', 'cart')
        ->first();
       

        if (!$order) {
            // Tạo đơn hàng mới nếu chưa có
            $order = Order::create([
                'customer_id' => $customer->id,
                'status' => 'cart',
                'order_code' => $order_code,
                'total_price' => 0, // Đúng: Dùng total_price
            ]);
        }

        // Tìm product variant dựa trên product_id, size và color
        $productVariant = ProductVariant::where('product_id', $data['product_id'])
            ->where('size', $data['size'])
            ->where('color', $data['color'])
            ->first();

        if (!$productVariant) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy biến thể sản phẩm phù hợp!'
            ]);
        }
        if ($productVariant->stock < $data['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng trong kho không đủ!'
            ]);
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
                'price' => $productVariant->product->price,
            ]);
        }

        // Cập nhật tổng tiền của đơn hàng
        $order->total_price = $order->items->sum(function ($item) {
            return $item->productVariant->product->price * $item->quantity;
        });
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
            'cartTotal' => $order->total_price,
            'order_id' => $order->id,
        ]);
    }

    public function updateCart(Request $request)
    {
        try {
            // Xử lý thêm/xóa sản phẩm từ giỏ hàng, cập nhật giỏ hàng
            $cart = Order::where('customer_id', Auth::user()->customer->id)
                ->where('status', 'pending')
                ->with('items.productVariant.product')
                ->first();

            if (!$cart) {
                return response()->json([
                    'message' => 'Giỏ hàng trống.',
                ], 400);
            }

            // Lưu lại các thay đổi giỏ hàng vào database (thêm/xóa sản phẩm)
            // Giả sử bạn đã xử lý xong việc thay đổi sản phẩm trong giỏ

            // Lấy lại voucher từ session (nếu có)
            $voucher = session('voucher');
            if ($voucher) {
                $voucherCode = $voucher['code'];
                $cart_total = 0;
                $selected_items = $request->input('selected_items', []);

                foreach ($cart->items as $item) {
                    if (empty($selected_items) || in_array($item->id, $selected_items)) {
                        $cart_total += $item->productVariant->product->price * $item->quantity;
                    }
                }

                // Tính toán lại giá trị giảm giá
                // Tính toán lại giá trị giảm giá
                if ($cart_total > 0) {
                    $discount = 0;

                    if ($voucher['discount_type'] === 'percentage') {
                        $discount = $cart_total * ($voucher['discount_value'] / 100);
                    } elseif ($voucher['discount_type'] === 'fixed') {
                        $discount = $voucher['discount_value'];
                    }

                    // Không cho phép giảm quá tổng
                    $discount = min($discount, $cart_total);

                    $new_total = $cart_total - $discount;

                    // Cập nhật lại session
                    session(['voucher' => [
                        'code' => $voucherCode,
                        'discount' => $discount,
                        'discount_type' => $voucher['discount_type'],
                        'discount_value' => $voucher['discount_value'],
                        'new_total' => $new_total,
                        'cart_total' => $cart_total,
                    ]]);

                    return response()->json([
                        'message' => 'Giỏ hàng đã được cập nhật.',
                        'new_total' => $new_total,
                        'cart_total' => $cart_total,
                        'voucher_code' => $voucherCode,
                        'discount' => $discount,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Không có voucher hoặc giỏ hàng không hợp lệ.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            return response()->json([
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
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
    public function clearCart()
    {
        // Lấy đơn hàng đang chờ (pending) của người dùng
        $order = Order::where('customer_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        // Nếu có đơn hàng
        if ($order) {
            // Xóa tất cả sản phẩm trong đơn hàng
            $order->items()->delete();
            // Xóa đơn hàng
            $order->delete();

            // Trả về thông báo xóa giỏ hàng thành công
            return response()->json([
                'success' => true,
                'cartTotal' => 0,
                'message' => 'Giỏ hàng đã được xóa.'
            ]);
        }

        // Nếu không có đơn hàng (giỏ hàng trống), trả về thông báo giỏ hàng trống
        return response()->json([
            'success' => false,
            'cartTotal' => 0,
            'message' => 'Giỏ hàng trống.'
        ]);
    }
}
