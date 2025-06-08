<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengguna yang sedang login.
     */
    public function show(Request $request): JsonResponse
    {
        $profile = $request->user()->profile()->firstOrCreate(
            ['user_id' => $request->user()->id]
        );
        
        return response()->json($profile);
    }

    /**
     * Memperbarui profil pengguna. (Logika yang Diperbaiki - Versi Final)
     */
    public function update(ProfileRequest $request): JsonResponse
    {
        // 1. Ambil data yang sudah divalidasi.
        $validatedData = $request->validated();
        $user = Auth::user();

        // 2. Langsung update data di database menggunakan relasi.
        // Ini lebih direct dan melewati beberapa 'magic' dari Eloquent save().
        $user->profile()->update($validatedData);
        
        // 3. Ambil kembali data user beserta profil yang sudah di-update.
        $updatedUser = $user->fresh()->load('profile');

        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'profile' => $updatedUser->profile,
        ]);
    }
}
