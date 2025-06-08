<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(LoginRequest $request): JsonResponse
    {
        // Validasi otomatis oleh LoginRequest

        // Coba untuk mengautentikasi pengguna
        if (!Auth::attempt($request->only('email', 'password'))) {
            // Jika gagal, kembalikan response error
            return response()->json([
                'message' => 'Invalid login details'
            ], 401); // 401 Unauthorized
        }

        // Jika berhasil, ambil data user
        $user = $request->user();

        // Hapus token lama (jika ada) dan buat token baru
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Kembalikan response sukses
        return response()->json([
            'message' => 'User logged in successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }
}