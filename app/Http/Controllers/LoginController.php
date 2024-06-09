<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        // Log::info($request->all());
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Log::info('Login berhasil');
            $request->session()->regenerate();

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $token,
                'abilities' => [
                    [
                        'action' => 'manage',
                        'subject' => 'Auth'
                    ]
                ]
            ], 200);
        } else {
            // Log::info('Login gagal');
            return response()->json([
                'message' => 'Login gagal. Unauthorized.',
            ], 401);
        }
        return response()->json([
            'message' => 'Login gagal. Forbidden.',
        ], 403);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json([
                'message' => 'Logout berhasil',
            ], 200);
        }
    }
}
