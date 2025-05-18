<?php

namespace App\Http\Controllers\admin\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }
    public function getUsersData()
    {
        $users = User::all();
        $usersData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'customer_name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'role' => $user->role,
                'password' => $user->password,
                'date' => $user->created_at->format('d M Y'),
                'phone' => $user->phone,
            ];
        });
        // dd($users);
        return response()->json($usersData);
    }
    public function store(Request $request)
{
    // Validate dữ liệu
    $request->validate([
        'customer_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:255',
        'date' => 'required|date',
        'status' => 'required|string|in:active,locked,banned',
        'role' => 'required|string|in:admin,user', // Nếu bạn có các vai trò xác định
        'password' => 'required|string|min:3', // Xác nhận mật khẩu
    ]);

    // Log request data
    // if ($request->fails()) {
    //     Log::error('Validation failed', $request->errors()->toArray());
    // }
    

    // Tạo người dùng mới
    $user = User::create([
        'name' => $request->customer_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password), // Mã hóa mật khẩu
        'status' => $request->status,
        'role' => $request->role,
        // '' => $request->date, // Nếu bạn muốn thêm ngày sinh
    ]);

    // Log thông tin người dùng đã tạo
    Log::info('User created:', $user->toArray());
    Log::info('User Store Request Data:', $request->all());
    // Trả về kết quả
    return response()->json([
        'success' => true,
        'message' => 'User added successfully!',
        'user' => $user,
    ], 201);
}

    public function update(Request $request, $id)
    {
       // Tìm user theo ID
    $user = User::findOrFail($id);

    // Validate dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'customer_name' => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email,' . $id,
        'phone'         => 'nullable|string|max:20',
        'password'      => 'nullable|string|min:6',
        'status'        => 'required|in:active,banned,locked', // tuỳ cách bạn định nghĩa status
        'role'          => 'required|in:user,admin',      // tuỳ vai trò bạn hỗ trợ
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422);
    }

    // Chuẩn bị dữ liệu để update
    $data = [
        'name'   => $request->customer_name,
        'email'  => $request->email,
        'phone'  => $request->phone,
        'status' => $request->status,
        'role'   => $request->role,
    ];

    // Nếu có mật khẩu mới thì mã hóa
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // Cập nhật
    $user->update($data);

    return response()->json([
        'success' => true,
        'message' => 'User updated successfully!',
        'user' => $user,
    ], 200);
    }
    public function destroy(string $id)
{
    try {
        // Tìm user theo id
        $user = User::findOrFail($id);

        // Xóa user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete user: ' . $e->getMessage()
        ], 500);
    }
}

}

