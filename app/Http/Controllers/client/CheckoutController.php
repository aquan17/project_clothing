<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    // Hiển thị trang thanh toán
    // Đoạn code bạn lưu voucher vào session


    // Hàm index trong CheckoutController bạn cung cấp
    public function index(Request $request)
{
    if (!$request->has('selected_items') || empty($request->selected_items)) {
        return redirect()->route('client.cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán.');
    }

    $customer = Auth::user()->customer;
    if (!$customer) {
        return redirect()->route('home')->with('error', 'Không tìm thấy thông tin khách hàng.');
    }

    $selectedItemIds = $request->input('selected_items', []);
    $selectedItems = OrderItem::with(['productVariant.product'])
        ->whereIn('id', $selectedItemIds)
        ->whereHas('order', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id)
                ->where('status', 'pending');
        })
        ->get();

    if ($selectedItems->isEmpty()) {
        return redirect()->route('client.cart.index')->with('error', 'Sản phẩm được chọn không hợp lệ.');
    }
// dd($selectedItemIds);
    $subtotal = $selectedItems->sum(function ($item) {
        return ($item->price ?? 0) * ($item->quantity ?? 0);
    });

    // --- Tính lại giảm giá ---
    $discount = 0;
    $voucherCode = null;
    $voucherData = Session::get('voucher');

    // Kiểm tra xem có voucher trong session không
    if ($voucherData && is_array($voucherData) && isset($voucherData['code'], $voucherData['discount_type'], $voucherData['discount_value'])) {
        $voucherCode = $voucherData['code'];

        if ($voucherData['discount_type'] === 'fixed') {
            $discount = (float) $voucherData['discount_value'];
        } elseif ($voucherData['discount_type'] === 'percentage') {
            $discount = $subtotal * ((float) $voucherData['discount_value'] / 100);

            if (isset($voucherData['max_discount'])) {
                $discount = min($discount, (float) $voucherData['max_discount']);
            }
        }

        $discount = min($discount, $subtotal);

        // Kiểm tra tính hợp lệ của voucher
        $couponId = null;
        $voucherModel = Coupon::where('code', $voucherCode)->first();
        if (
            !$voucherModel ||
            $voucherModel->status !== 'active' ||
            $voucherModel->start_date > now() ||
            $voucherModel->end_date < now() ||
            ($voucherModel->min_order_value && $subtotal < $voucherModel->min_order_value)
        ) {
            Session::forget('voucher');
            $voucherCode = null;
            $discount = 0;
        } else {
            $couponId = $voucherModel->id; // Gán giá trị cho couponId nếu voucher hợp lệ
        }
    }

    $shippingFee = ($subtotal > 0 && $subtotal < 500) ? 30 : 0;
    $finalTotal = max(0, $subtotal - $discount + $shippingFee);

    $defaultAddress = ShippingAddress::where('customer_id', $customer->id)
        ->where('is_default', 1)
        ->first();

        if ($voucherCode) {
            session([
                'order_info' => [
                    'selectedItems' => $selectedItems,
                    'coupon_id' => $couponId,
                    'subtotal' => $subtotal,
                    'voucherCode' => $voucherCode,
                    'discount' => $discount,
                    'shippingFee' => $shippingFee,
                    'finalTotal' => $finalTotal,
                    'defaultAddress' => $defaultAddress,
                ]
            ]);
        } else {
            // Nếu không có voucher, không lưu voucher vào session
            session([
                'order_info' => [
                    'selectedItems' => $selectedItems,
                    'selectedItemIds' => $selectedItemIds,
                    'subtotal' => $subtotal,
                    'shippingFee' => $shippingFee,
                    'finalTotal' => $finalTotal,
                    'defaultAddress' => $defaultAddress,
                ]
            ]);
        }

    // dd(session('order_info')); // Debug session để xem giá trị của order_info

    return view('client.checkout', [
        'selectedItems' => $selectedItems,
        'subtotal' => $subtotal,
        'voucherCode' => $voucherCode,
        'discount' => $discount,
        'shippingFee' => $shippingFee,
        'finalTotal' => $finalTotal,
        'defaultAddress' => $defaultAddress,
    ]);
}



    // Hàm kiểm tra voucher (đã có sẵn)
    // private function isVoucherStillValid($code, $subtotal, $items)
    // {
    //     if (!$code) return false;
    //     // Đảm bảo Model Coupon tồn tại và đúng tên namespace
    //     $voucher = \App\Models\Coupon::where('code', $code)->first();
    //     // Kiểm tra trạng thái - đảm bảo cột 'status' và giá trị 'active' là đúng
    //     if (!$voucher || $voucher->status !== 'active') {
    //         return false;
    //     }
    //     // TODO: Thêm các kiểm tra khác nếu cần (hạn sử dụng, min_spend, giới hạn lượt dùng, sản phẩm áp dụng...)
    //     return true;
    // }


    // Xử lý đặt hàng
    // public function processPayment(Request $request)
    // {
    //     Log::info('Checkout form data: ' . json_encode($request->all()));

    //     // Validate dữ liệu từ form
    //     $validated = $request->validate([
    //         'selected_items' => 'required|array',
    //         'selected_items.*' => 'exists:product_variants,id',
    //         'shipping_option' => 'required|in:free_shipping',
    //         'payment_option' => 'required|in:cash_on_delivery,paypal',
    //         'terms_condition' => 'required|accepted',
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // Lấy thông tin khách hàng
    //         $customer = $this->getOrCreateCustomer($request);

    //         // Lưu địa chỉ giao hàng
    //         $shippingAddress = $this->saveShippingAddress($request, $customer->id);

    //         // Lấy danh sách sản phẩm trong giỏ hàng
    //         $cartItems = OrderItem::whereIn('id', $request->selected_items)
    //             ->with(['productVariant.product'])
    //             ->get();

    //         if ($cartItems->isEmpty()) {
    //             throw new \Exception('Không tìm thấy sản phẩm trong giỏ hàng.');
    //         }

    //         // Tính tổng tiền
    //         $total = 0;
    //         foreach ($cartItems as $item) {
    //             if ($item->productVariant && $item->productVariant->product) {
    //                 $total += $item->productVariant->product->price * $item->quantity;
    //             } else {
    //                 Log::warning('Thiếu productVariant hoặc product cho item: ' . json_encode($item));
    //                 throw new \Exception('Sản phẩm trong giỏ hàng không hợp lệ.');
    //             }
    //         }

    //         // Lấy voucher từ session
    //         // Lấy voucher từ session
    //         $voucherDiscount = 0;
    //         $voucherCode = null;
    //         $coupon_id = null;

    //         if (session()->has('voucher')) {
    //             $voucher = session('voucher');
    //             $voucherDiscount = $voucher['discount'] ?? 0;
    //             $voucherCode = $voucher['code'] ?? null;

    //             if ($voucherCode) {
    //                 $coupon = Coupon::where('code', $voucherCode)->first();
    //                 if ($coupon) {
    //                     $coupon_id = $coupon->id;
    //                     $coupon->increment('used_count'); // Tăng lượt dùng
    //                     Log::info("Coupon used: {$coupon->code}, new used_count: {$coupon->used_count}");
    //                 } else {
    //                     Log::warning("Coupon not found for code: {$voucherCode}");
    //                 }
    //             }
    //         }

    //         Log::info('Voucher in session: ' . json_encode(session('voucher')));

    //         // Tính tổng sau khi giảm
    //         $totalAfterDiscount = max($total - $voucherDiscount, 0);

    //         // Tạo đơn hàng
    //         $order = Order::create([
    //             'order_code' => $this->generateOrderCode(),
    //             'customer_id' => $customer->id,
    //             // 'user_id' => Auth::user()->id,
    //             'shipping_address_id' => $shippingAddress->id,
    //             'total_price' => $totalAfterDiscount,
    //             'voucher_discount' => $voucherDiscount,
    //             'coupon_id' => $coupon_id,
    //             'shipping_fee' => 0.00,
    //             'status' => 'confirmed',
    //             'payment_method' => $request->payment_option,
    //             'payment_status' => $request->payment_option === 'cash_on_delivery' ? 'unpaid' : 'paid',
    //             'notes' => $request->order_notes,
    //         ]);



    //         // Lưu chi tiết đơn hàng
    //         foreach ($cartItems as $item) {
    //             OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_variant_id' => $item->product_variant_id,
    //                 'quantity' => $item->quantity,
    //                 'price' => $item->productVariant->product->price,
    //             ]);

    //             // Trừ số lượng tồn kho
    //             $item->productVariant->decrement('stock', $item->quantity);
    //         }

    //         // Xóa sản phẩm đã mua khỏi giỏ hàng
    //         OrderItem::whereIn('id', $request->selected_items)->delete();

    //         // Tạo thông báo
    //         Notification::create([
    //             'customer_id' => $customer->id,
    //             'title' => 'Đơn hàng đã được đặt',
    //             'message' => 'Đơn hàng #' . $order->order_code . ' của bạn đã được đặt thành công. Chúng tôi sẽ liên hệ sớm!',
    //             'is_read' => 0,
    //         ]);

    //         DB::commit();

    //         // Redirect tới trang xác nhận đơn hàng
    //         return redirect()->route('client.confirmation', $order->id)
    //             ->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Error processing payment: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'Có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại.']);
    //     }
    // }





    // private function getOrCreateCustomer(Request $request)
    // {
    //     // Nếu người dùng đã đăng nhập, dùng thông tin của họ, nếu không, dùng thông tin khách vãng lai
    //     $user = Auth::user();
    //     $email = $user ? $user->email : ($request->email ?? 'guest_' . uniqid() . '@example.com');

    //     // Nếu không lưu thông tin vào bảng `customers`, chỉ cần trả về thông tin người dùng hoặc khách vãng lai
    //     return (object)[
    //         'id' => $user ? $user->id : null,
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'email' => $email
    //     ];
    // }


    // private function saveShippingAddress(Request $request, $customerId)
    // {
    //     $shippingAddress = ShippingAddress::create([
    //         'customer_id' => $customerId,
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'country' => $request->country,
    //         'province' => $request->province,
    //         'district' => $request->district,
    //         'ward' => $request->ward,
    //         'notes' => $request->notes,
    //         'is_default' => $request->is_default ?? 0,
    //     ]);

    //     // Nếu là địa chỉ mặc định, cập nhật các địa chỉ khác của khách hàng
    //     if ($request->is_default) {
    //         ShippingAddress::where('customer_id', $customerId)
    //             ->where('id', '!=', $shippingAddress->id)
    //             ->update(['is_default' => 0]);
    //     }

    //     return $shippingAddress;
    // }

    // private function generateOrderCode()
    // {
    //     return '#ORD' . str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT);
    // }
    // public function confirmation(Order $order)
    // {
    //     // Load thêm các quan hệ cần thiết
    //     $order->load('items.productVariant.product', 'customer');

    //     // Đảm bảo chỉ khách hàng sở hữu đơn hàng hoặc admin mới xem được
    //     if (Auth::check() && ($order->customer->user_id === Auth::id() || Auth::user()->role === 'admin')) {
    //         return view('client.confirmation', compact('order'));
    //     }

    //     return redirect()->route('home')->withErrors(['error' => 'Bạn không có quyền xem đơn hàng này.']);
    // }
}
