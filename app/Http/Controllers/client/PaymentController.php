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
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
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
            'payment_method' => 'required|in:cash,credit,debit,paypal,momo',
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
        // MOMO
        if ($paymentMethod === 'momo') {
            try {
                DB::beginTransaction();

                $orderCode = 'ORD-' . strtoupper(uniqid());
                $finalTotal = $order['finalTotal'];
                $voucherDiscount = $order['discount'] ?? 0;
                $shippingFee = $order['shippingFee'] ?? 0;
                $couponId = $order['coupon_id'] ?? null;
                $notes = $order['notes'] ?? '';

                // Tạo đơn hàng
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

                // Thêm chi tiết đơn hàng & cập nhật tồn kho
                foreach ($order['selectedItems'] as $item) {
                    $productVariant = ProductVariant::find($item->product_variant_id);
                    if (!$productVariant) {
                        throw new \Exception('Không tìm thấy biến thể sản phẩm.');
                    }
                    if ($productVariant->stock < $item->quantity) {
                        throw new \Exception('Sản phẩm "' . $productVariant->size . ' - ' . $productVariant->color . '" không đủ tồn kho.');
                    }
                    $orderModel->items()->create([
                        'product_variant_id' => $item->product_variant_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ]);
                    $productVariant->decrement('stock', $item->quantity);
                }

                // Ghi thông tin thanh toán
                $orderModel->payment()->create([
                    'method' => $paymentMethod,
                    'amount' => $finalTotal,
                    'status' => 'pending',
                ]);

                // Ghi nhận sử dụng coupon
                if ($couponId) {
                    $coupon = Coupon::find($couponId);
                    $coupon->increment('used_count');
                }

                // Tạo thông báo
                $orderModel->notifications()->create([
                    'customer_id' => Auth::user()->customer->id,
                    'message' => "Đơn hàng {$orderCode} của bạn đã được tạo thành công.",
                    'notifiable_id' => $orderModel->id,
                ]);

                DB::commit();

                // Xóa giỏ hàng
                $selectedCartItemIds = collect($order['selectedItems'])->pluck('id')->toArray();
                OrderItem::whereIn('id', $selectedCartItemIds)->delete();

                // Gọi hàm xử lý redirect sang Momo
                return $this->redirectToMomo($orderModel, $finalTotal);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('❌ Lỗi khi tạo đơn hàng MoMo:', ['exception' => $e->getMessage()]);
                return back()->with('error', 'Đã có lỗi xảy ra khi xử lý đơn hàng: ' . $e->getMessage());
            }
        }
        // end MOMO
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
    protected function redirectToMomo(Order $orderModel, $amount)
    {

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secrectkey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $usdAmount = $orderModel->total_price; // Giả sử đang là giá USD
        $exchangeRate = 24000;

        $amount = (int) round($usdAmount * $exchangeRate);
        // dd($amount);

        if ($amount < 10000) {
            return redirect()->route('payment.cod', ['orderCode' => $orderModel->order_code])
                ->with('error', 'Số tiền thanh toán tối thiểu qua MoMo là 10.000 VND.');
        }

        $orderId = time() . "";
        $redirectUrl = route('client.confirmation', ['orderCode' => $orderModel->order_code]);
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";

        $extraData = "";

        $requestId = time() . "";
        $requestType = "payWithATM";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secrectkey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => (string)$amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        // dd($data);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        //Just a example, please check more in there
        return redirect($jsonResult['payUrl']);
    }

    protected function getMomoPaymentUrl(Order $orderModel, $amount)
    {

        return 'https://momo-payment-link.example.com';
    }
}
