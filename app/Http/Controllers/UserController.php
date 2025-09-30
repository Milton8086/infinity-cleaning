<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\auth;

class UserController extends Controller
{  
    // User Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'role' => 'required|in:customer,staff,admin',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);
        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
    // User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        // Generate token (for simplicity, using a static token here)
        $token = bin2hex(random_bytes(40));

        return response()->json(['message' => 'Login successful', 'token' => $token], 200);
    }
    // Get User Profile
    public function profile(Request $request)
    {
        // Assuming user is authenticated and user ID is available
        $user = User::find($request->user()->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }
    // Update User Profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|nullable|string|max:15',
        ]);
        $user = User::find($request->user()->id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        $user->save();
        return response()->json(['message' => 'Profile updated successfully', 'user' => $user], 200);
    }
    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($request->user()->id);
        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 401);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json(['message' => 'Password changed successfully'], 200);
    }
    // User Logout
    public function logout(Request $request)
    {
        // Invalidate the token (for simplicity, not implemented here)
        return response()->json(['message' => 'Logout successful'], 200);
    }
}
        