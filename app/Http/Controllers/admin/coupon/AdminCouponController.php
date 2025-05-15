<?php

namespace App\Http\Controllers\admin\coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'required|integer|min:0',
            'used_count' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        Coupon::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
            'used_count' => $request->used_count,
            'status' => $request->status
        ]);

          return redirect()->back()->with('success', 'Coupon create successfully.');
    }

    public function edit($id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount_type' => $coupon->discount_type, // Fixed typo
                'discount_value' => $coupon->discount_value,
                'start_date' => $coupon->start_date,
                'end_date' => $coupon->end_date,
                'usage_limit' => $coupon->usage_limit,
                'used_count' => $coupon->used_count,
                // 'status' => $coupon->status,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error loading coupon data'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric',
            'start_date' => 'required|date|date_format:Y-m-d\TH:i',
            'end_date' => 'required|date|date_format:Y-m-d\TH:i|after:start_date',
            'usage_limit' => 'required|integer|min:0',
            'used_count' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'usage_limit' => $request->usage_limit,
            'used_count' => $request->used_count,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['success' => true]);
    }
}
