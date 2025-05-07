<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        return view('client.profile.info');
    }

    // public function updateProfile(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'phone' => 'nullable|string|max:20',
    //         'address' => 'nullable|string|max:255',
    //         'shipping_name' => 'nullable|string|max:255', 
    //         'shipping_phone' => 'nullable|string|max:20',
    //         'shipping_address' => 'nullable|string|max:255'
    //     ]);

    //     $user = Auth::user();
        
    //     $user->update([
    //         'name' => $request->name,
    //         'phone' => $request->phone,
    //         'address' => $request->address,
    //         'shipping_name' => $request->shipping_name,
    //         'shipping_phone' => $request->shipping_phone, 
    //         'shipping_address' => $request->shipping_address
    //     ]);

    //     return redirect()->back()->with('success', 'Profile updated successfully');
    // }

    // public function updatePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'password' => 'required|string|min:8|confirmed'
    //     ]);

    //     $user = Auth::user();

    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return back()->withErrors(['current_password' => 'Current password is incorrect']);
    //     }

    //     $user->update([
    //         'password' => Hash::make($request->password)
    //     ]);

    //     return redirect()->back()->with('success', 'Password changed successfully');
    // }
}
