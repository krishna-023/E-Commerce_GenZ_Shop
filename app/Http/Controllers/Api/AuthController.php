<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * User login (API)
     */
public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    $user = Auth::user();

    // Create Sanctum token
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
}


    /**
     * User registration (API)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        event(new \Illuminate\Auth\Events\Registered($user));

        return redirect('/home')->with('success', 'Registration successful. You are now logged in.');
    }

    /**
     * Logout (API)
     */
   public function logout(Request $request)
{
    // Delete the token that was used for this request
    if ($request->user()->currentAccessToken()) {
$request->user()->currentAccessToken()?->delete();
    }

    return response()->json(['message' => 'Logged out successfully']);
}


    /**
     * Get authenticated user info (API)
     */
   public function user(Request $request)
{
    $user = $request->user();
    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Unauthenticated'], 401);
    }

    return response()->json([
        'status' => true,
        'user' => [
            'name' => $user->name,
            'email' => $user->email
        ]
    ]);
}

}
