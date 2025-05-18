<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VoucherController extends Controller
{
    public function applyVoucher(Request $request)
{
    try {
        // Validate request
        $request->validate([
            'voucher_code' => 'required|string',
            'selected_items' => 'nullable|array',
            'selected_items.*' => 'exists:order_items,id',
        ]);
        
        // Tìm voucher
        $voucher = Coupon::where('code', $request->voucher_code)
            ->where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$voucher) {
            Log::warning('Voucher không hợp lệ hoặc đã hết hạn', ['voucher_code' => $request->voucher_code]);
            return response()->json([
                'message' => 'Voucher không hợp lệ hoặc đã hết hạn.',
            ], 400);
        }

        if ($voucher->used_count >= $voucher->usage_limit) {
            return response()->json([
                'message' => 'Voucher này đã được sử dụng hết.',
            ], 400);
        }

        // Lấy giỏ hàng
        $cart = Order::where('customer_id', Auth::user()->customer->id)
            ->where('status', 'cart')
            ->with('items.productVariant.product')
            ->first();

        if (!$cart) {
            return response()->json([
                'message' => 'Giỏ hàng trống.',
            ], 400);
        }

        // Xóa voucher cũ nếu có
        if ($cart->coupon) {
            $cart->coupon()->dissociate();
            $cart->save();
        }

        // Tính tổng tiền
        $cart_total = 0;
        $selected_items = $request->input('selected_items', []);
        foreach ($cart->items as $item) {
            if (empty($selected_items) || in_array($item->id, $selected_items)) {
                $cart_total += $item->productVariant->product->price * $item->quantity;
            }
        }

        if ($cart_total == 0) {
            return response()->json([
                'message' => 'Vui lòng chọn ít nhất một sản phẩm.',
            ], 400);
        }

        // Tính giảm giá
        $discount = 0;
        if ($voucher->discount_type === 'percentage') {
            $discount = $this->applyPercentageDiscount($voucher, $cart_total);
        } elseif ($voucher->discount_type === 'fixed') {
            $discount = $this->applyFixedDiscount($voucher);
        }

        $new_total = $cart_total - $discount;

        // Đảm bảo discount không âm hoặc null
        $voucherDiscount = $discount > 0 ? $discount : 0;

        // Lưu voucher vào giỏ hàng
        // $cart->coupon()->associate($voucher);
        // $cart->voucher_discount = $voucherDiscount;
        // $cart->save();

        // Cập nhật số lần sử dụng voucher (mở lại dòng này nếu cần)
        // $voucher->increment('used_count');

        // Lưu vào session (có thể bỏ nếu không cần)
        session(['voucher' => [
            'code' => $voucher->code,
            'discount_type' => $voucher->discount_type,
            'discount_value' => $voucher->discount_value,
            // 'discount' => $voucherDiscount,
        ]]);

        return response()->json([
            'message' => 'Voucher đã được áp dụng.',
            'coupon' => $voucher,
            'voucher_code' => $voucher->code,
            'discount' => $voucherDiscount,
            'new_total' => $new_total,
            'cart_total' => $cart_total,
            'discount_type' => $voucher->discount_type
        ]);
    } catch (\Exception $e) {
        Log::error('Voucher apply error: ' . $e->getMessage());
        return response()->json([
            'message' => 'Đã có lỗi xảy ra, vui lòng thử lại.',
        ], 500);
    }
}


    // Apply percentage discount
    private function applyPercentageDiscount(Coupon $voucher, $cartTotal)
    {
        if ($voucher->discount_value <= 0) {
            Log::warning('Voucher phần trăm không hợp lệ', ['voucher_code' => $voucher->code]);
            return 0;
        }
    
        return ($cartTotal * $voucher->discount_value) / 100;
    }
    

    // Apply fixed discount
   // Apply fixed discount
private function applyFixedDiscount(Coupon $voucher)
{
    if ($voucher->discount_value <= 0) {
        Log::warning('Voucher không có giá trị giảm giá hợp lệ', ['voucher_code' => $voucher->code]);
        return 0;
    }

    return $voucher->discount_value;
}

    public function removeVoucher(Request $request)
    {
         try {
        // Get cart with status 'cart' instead of 'pending'
        $cart = Order::where('customer_id', Auth::user()->customer->id)
            ->where('status', 'cart') // Changed from 'pending' to 'cart'
            ->with('items.productVariant.product')
            ->first();

        // Clear session voucher data
        $request->session()->forget('voucher'); // Use this instead of session(['voucher' => null])

        // If cart exists, update it
        if ($cart) {
            $cart->coupon()->dissociate();
            $cart->voucher_discount = 0;
            $cart->save();

            $cart_total = $cart->items->sum(function($item) {
                return $item->productVariant->product->price * $item->quantity;
            });

            return response()->json([
                'message' => 'Voucher đã được loại bỏ.',
                'cart_total' => $cart_total,
            ]);
        }

        return response()->json([
            'message' => 'Voucher đã được loại bỏ.',
        ]);

    } catch (\Exception $e) {
        Log::error('Voucher remove error: ' . $e->getMessage());
        return response()->json([
            'message' => 'Đã có lỗi xảy ra khi loại bỏ voucher, vui lòng thử lại.',
        ], 500);
    }
    }
}
