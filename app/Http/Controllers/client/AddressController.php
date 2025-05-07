<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Thêm Log để debug nếu cần

class AddressController extends Controller
{
    /**
     * Display a listing of the user's addresses.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!Auth::check() || !Auth::user()->customer) {
            Log::warning('AddressController::index - User not logged in or has no customer profile.');
             // Xử lý khi người dùng chưa đăng nhập hoặc chưa có thông tin khách hàng
             if ($request->ajax()) {
                 return response()->json([]); // Trả về mảng rỗng cho AJAX
             }
             // Chuyển hướng đến trang đăng nhập hoặc trang tạo hồ sơ khách hàng
             // Ví dụ: return redirect()->route('login');
             // Hoặc trả về view với thông báo
             return view('client.address', ['addresses' => collect(), 'message' => 'Vui lòng đăng nhập để xem địa chỉ.']);
         }

        $customerId = Auth::user()->customer->id;

        $addresses = ShippingAddress::where('customer_id', $customerId)
            ->orderByDesc('is_default') // Sắp xếp mặc định lên đầu (nên làm)
            ->get()
            ->map(function ($address) {
                // Ghép chuỗi địa chỉ đầy đủ
                $fullAddressParts = array_filter([
                    $address->notes, // Thêm cả notes nếu có và muốn hiển thị ở đây
                    $address->ward,
                    $address->district,
                    $address->province,
                    // $address->country ?? 'Việt Nam' // Thêm quốc gia nếu cần
                ]);
                $fullAddress = implode(', ', $fullAddressParts);

                // *** TRẢ VỀ ĐẦY ĐỦ CÁC TRƯỜNG CHO JSON ***
                return [
                    'id' => $address->id,
                    'is_default' => (bool) $address->is_default, // Sử dụng is_default
                    'name' => $address->name,
                    'phone' => $address->phone,
                    'province' => $address->province, // <<< THÊM LẠI
                    'district' => $address->district, // <<< THÊM LẠI
                    'ward' => $address->ward,       // <<< THÊM LẠI
                    'notes' => $address->notes ?? '',    // <<< THÊM LẠI (nếu có trường notes)
                    'country' => $address->country ?? 'Việt Nam', // <<< THÊM LẠI (nếu có)
                    'full_address' => $fullAddress,      // Giữ lại địa chỉ ghép chuỗi để hiển thị
                    // 'checked' => (bool) $address->is_default, // Có thể bỏ 'checked' đi nếu dùng 'is_default'
                ];
            });

        // For AJAX requests, return JSON đã được map đầy đủ
        if ($request->ajax()) {
            return response()->json($addresses);
        }

        // For regular requests, return view with addresses (đã được map)
        return view('client.address', compact('addresses'));
    }

    // --- Các phương thức khác (setDefault, store, update, destroy) giữ nguyên như bạn đã gửi ---
    // --- Đảm bảo là các phương thức store và update có lưu các trường province, district, ward, notes ---

    /**
     * Set an address as default.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function setDefault($id)
    {
        if (!Auth::check() || !Auth::user()->customer) {
             return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
         }
        $customerId = Auth::user()->customer->id;

        try {
            // Reset all addresses to non-default
            ShippingAddress::where('customer_id', $customerId)
                ->update(['is_default' => false]);

            // Set the selected address as default
            $address = ShippingAddress::where('id', $id)
                ->where('customer_id', $customerId)
                ->firstOrFail(); // Sẽ trả về lỗi 404 nếu không tìm thấy

            $address->is_default = true;
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Địa chỉ đã được đặt làm mặc định thành công!' // Tiếng Việt
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("setDefault Address Error: Address ID {$id} not found for customer {$customerId}");
             return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ.'], 404); // Tiếng Việt
        } catch (\Exception $e) {
             Log::error("setDefault Address Error: " . $e->getMessage());
             return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi đặt địa chỉ mặc định.'], 500); // Tiếng Việt
         }
    }

    /**
     * Store a newly created address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->customer) {
            // Handle unauthorized access
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500', // Thêm validation nếu có trường notes
            'country' => 'nullable|string|max:100', // Thêm validation nếu có trường country
            'is_default' => 'sometimes|boolean', // Dùng sometimes nếu trường này không phải lúc nào cũng gửi lên
        ]);

        $customerId = Auth::user()->customer->id;
        $isDefaultRequest = filter_var($request->input('is_default', false), FILTER_VALIDATE_BOOLEAN);


        // If this address is set as default, reset other addresses
        if ($isDefaultRequest) {
            ShippingAddress::where('customer_id', $customerId)
                ->update(['is_default' => false]);
        }

        // Check if this is the first address for the customer
        $isFirstAddress = !ShippingAddress::where('customer_id', $customerId)->exists();

        // Create new address
        $address = new ShippingAddress();
        $address->customer_id = $customerId;
        $address->name = $validatedData['name'];
        $address->phone = $validatedData['phone'];
        $address->province = $validatedData['province'];
        $address->district = $validatedData['district'];
        $address->ward = $validatedData['ward'];
        $address->notes = $validatedData['notes'] ?? null;
        $address->country = $validatedData['country'] ?? 'Việt Nam';
        // Make default if requested OR if it's the first address
        $address->is_default = $isDefaultRequest || $isFirstAddress;
        $address->save();

        // Format the newly created address similar to the index method for consistency
         $formattedAddress = [
             'id' => $address->id,
             'is_default' => (bool) $address->is_default,
             'name' => $address->name,
             'phone' => $address->phone,
             'province' => $address->province,
             'district' => $address->district,
             'ward' => $address->ward,
             'notes' => $address->notes ?? '',
             'country' => $address->country ?? 'Việt Nam',
             'full_address' => implode(', ', array_filter([$address->notes, $address->ward, $address->district, $address->province])),
         ];

        // Return JSON response for AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Địa chỉ đã được thêm thành công!', // Tiếng Việt
                'address' => $formattedAddress // Trả về địa chỉ đã được format
            ]);
        }

        // Redirect for non-AJAX request (optional)
        return redirect()->route('client.address.index') // Sửa tên route nếu cần
            ->with('success', 'Địa chỉ đã được thêm thành công!'); // Tiếng Việt
    }

    /**
     * Update the specified address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
         if (!Auth::check() || !Auth::user()->customer) {
             return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
         }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
            'country' => 'nullable|string|max:100',
            'is_default' => 'sometimes|boolean',
        ]);

        $customerId = Auth::user()->customer->id;

        try {
            // Find the address
            $address = ShippingAddress::where('id', $id)
                ->where('customer_id', $customerId)
                ->firstOrFail();

             $isDefaultRequest = filter_var($request->input('is_default', $address->is_default), FILTER_VALIDATE_BOOLEAN);


            // If this address is set as default AND it wasn't default before, reset others
            if ($isDefaultRequest && !$address->is_default) {
                ShippingAddress::where('customer_id', $customerId)
                    ->where('id', '!=', $id) // Don't reset itself
                    ->update(['is_default' => false]);
            }

            // Update address fields
            $address->name = $validatedData['name'];
            $address->phone = $validatedData['phone'];
            $address->province = $validatedData['province'];
            $address->district = $validatedData['district'];
            $address->ward = $validatedData['ward'];
            $address->notes = $validatedData['notes'] ?? $address->notes; // Giữ giá trị cũ nếu không có
            $address->country = $validatedData['country'] ?? $address->country;
            $address->is_default = $isDefaultRequest;
            $address->save();

            // Format the updated address
             $formattedAddress = [
                 'id' => $address->id,
                 'is_default' => (bool) $address->is_default,
                 'name' => $address->name,
                 'phone' => $address->phone,
                 'province' => $address->province,
                 'district' => $address->district,
                 'ward' => $address->ward,
                 'notes' => $address->notes ?? '',
                 'country' => $address->country ?? 'Việt Nam',
                 'full_address' => implode(', ', array_filter([$address->notes, $address->ward, $address->district, $address->province])),
             ];


            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Địa chỉ đã được cập nhật thành công!', // Tiếng Việt
                    'address' => $formattedAddress // Trả về địa chỉ đã format
                ]);
            }

            return redirect()->route('client.address.index') // Sửa tên route nếu cần
                ->with('success', 'Địa chỉ đã được cập nhật thành công!'); // Tiếng Việt

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             Log::error("Update Address Error: Address ID {$id} not found for customer {$customerId}");
             return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ.'], 404); // Tiếng Việt
         } catch (\Exception $e) {
             Log::error("Update Address Error: " . $e->getMessage());
             return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật địa chỉ.'], 500); // Tiếng Việt
         }
    }

    /**
     * Remove the specified address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id) // Thêm Request $request
    {
         if (!Auth::check() || !Auth::user()->customer) {
             return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
         }

        $customerId = Auth::user()->customer->id;

        try {
            // Find the address
            $address = ShippingAddress::where('id', $id)
                ->where('customer_id', $customerId)
                ->firstOrFail();

            $wasDefault = $address->is_default;

            // Delete the address
            $address->delete();

            // If this was the default address, set another one as default if available
            if ($wasDefault) {
                $newDefault = ShippingAddress::where('customer_id', $customerId)
                                            ->orderBy('created_at', 'asc') // Chọn cái cũ nhất làm mặc định mới
                                            ->first();
                if ($newDefault) {
                    $newDefault->is_default = true;
                    $newDefault->save();
                    Log::info("Promoted address ID {$newDefault->id} to default for customer {$customerId}");
                } else {
                     Log::info("No other addresses found to promote to default for customer {$customerId}");
                 }
            }

            // Luôn kiểm tra $request->ajax() thay vì request() helper
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Địa chỉ đã được xóa thành công!' // Tiếng Việt
                ]);
            }

            return redirect()->route('client.address.index') // Sửa tên route nếu cần
                ->with('success', 'Địa chỉ đã được xóa thành công!'); // Tiếng Việt

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
             Log::error("Destroy Address Error: Address ID {$id} not found for customer {$customerId}");
             return response()->json(['success' => false, 'message' => 'Không tìm thấy địa chỉ.'], 404); // Tiếng Việt
         } catch (\Exception $e) {
             Log::error("Destroy Address Error: " . $e->getMessage());
             return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa địa chỉ.'], 500); // Tiếng Việt
         }
    }
}