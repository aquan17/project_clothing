<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesDB;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    // Hiển thị trang thanh toán
    public function showPaymentPage(Request $request)
    {
        // Lấy thông tin đơn hàng từ session
        $order = session('order_info');
        Log::info('Đang xử lý thanh toán', ['data' => $request->all()]);
        // Nếu không tìm thấy thông tin đơn hàng, chuyển hướng về giỏ hàng
        if (!$order) {
            Log::warning('Không có dữ liệu order_info trong session, redirect về giỏ hàng');
            return redirect()->route('client.cart.index')->with('error', 'Không tìm thấy thông tin đơn hàng.');
        }
        // dd($order);
        // Trả về trang thanh toán với thông tin đơn hàng
        return view('client.payment', compact('order'));
    }

    // Xử lý thanh toán
    public function handleCashOnDelivery(Request $request)
    {

        $validated = $request->validate([
            'payment_method' => 'required|in:cash,credit,debit,paypal',
        ]);


        $order = session('order_info');
        Log::info('Submit đơn hàng - dữ liệu từ session:', ['order_info' => $order]);
        if (!$order) {
            Log::warning('Không có dữ liệu order_info khi submit đơn hàng');
            return redirect()->route('client.cart.index')->with('error', 'Không tìm thấy thông tin đơn hàng.');
        }
        Log::info('🔍 SESSION order_info:', session()->all());

        $paymentMethod = $request->input('payment_method');

        if (!$paymentMethod) {
            return redirect()->route('client.payment.showPaymentPage')->with('error', 'Vui lòng chọn phương thức thanh toán.');
        }

        try {
            DB::beginTransaction();

            $finalTotal = $order['finalTotal'];
            if ($paymentMethod == 'cod') {
                $finalTotal += 10000;
            }

            $voucherDiscount = $order['discount'] ?? 0;
            $shippingFee = $order['shippingFee'] ?? 0;
            $couponId = $order['coupon_id'] ?? null;
            $notes = $order['notes'] ?? '';

            $orderCode = 'ORD-' . strtoupper(uniqid());

            // 1. Tạo đơn hàng
            $orderModel = Order::create([
                'order_code' => $orderCode,
                'customer_id' => Auth::user()->customer->id,
                'shipping_address_id' => $order['defaultAddress']->id,
                'total_price' => $finalTotal,
                'voucher_discount' => $voucherDiscount,
                'coupon_id' => $couponId,
                'shipping_fee' => $shippingFee,
                'status' => 'pending',
                'payment_method' => $paymentMethod,
                'payment_status' => 'unpaid',
                'notes' => $notes,
                'user_id' => Auth::id(),
            ]);

            // 2. Thêm chi tiết đơn hàng & cập nhật tồn kho
            foreach ($order['selectedItems'] as $item) {
                $productVariant = ProductVariant::find($item->product_variant_id);

                if (!$productVariant) {
                    throw new \Exception('Không tìm thấy biến thể sản phẩm.');
                }

                if ($productVariant->stock < $item->quantity) {
                    throw new \Exception('Sản phẩm "' . $productVariant->size . ' - ' . $productVariant->color . '" không đủ tồn kho.');
                }


                // Tạo chi tiết đơn hàng
                $orderModel->items()->create([
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                // Trừ tồn kho
                $productVariant->decrement('stock', $item->quantity);
            }


            // 3. Ghi thông tin thanh toán
            $orderModel->payment()->create([
                'method' => $paymentMethod,
                'amount' => $finalTotal,
                'status' => 'pending',
                // 'method' => $paymentMethod,
            ]);

            // 4. Ghi nhận sử dụng coupon (nếu có)
            if ($couponId) {
                $couponId = Coupon::find($couponId);
                $couponId->increment('used_count');
            }

            // 5. Tạo thông báo
            $orderModel->notifications()->create([
                'customer_id' => Auth::user()->customer->id,
                'message' => "Đơn hàng {$orderCode} của bạn đã được tạo thành công.",
                'notifiable_id' => $orderModel->id,
                // 'title' => 'order',
            ]);

            DB::commit();
            // $orderModel->delete();
            session()->forget('order_info');
            Log::info('Redirecting to confirmation page...');
            // Xóa các sản phẩm trong giỏ hàng sau khi đặt hàng thành công
            $selectedCartItemIds = collect($order['selectedItems'])->pluck('id')->toArray();

            OrderItem::whereIn('id', $selectedCartItemIds)->delete();

            return redirect()->route('client.confirmation', ['orderCode' => $orderCode]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('❌ Lỗi khi tạo đơn hàng:', ['exception' => $e->getMessage()]);
            dd($e->getMessage());

            return back()->with('error', 'Đã có lỗi xảy ra khi xử lý đơn hàng: ' . $e->getMessage());
        }
    }
    // Trang thành công sau khi thanh toán
    public function success($orderCode)
    {
        $order = Order::with([
            'items.productVariant.product',
            'shippingAddress'
        ])->where('order_code', $orderCode)
            ->where('status', 'pending')
            ->firstOrFail();
        // dd($order);
        return view('client.confirmation', compact('order'));
    }
}
