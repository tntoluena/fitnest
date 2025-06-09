<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $profile = $request->user()->profile()->firstOrCreate(
            ['user_id' => $request->user()->id]
        );
        
        return response()->json($profile);
    }

    public function update(ProfileRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = Auth::user();

        $user->profile()->update($validatedData);

        $updatedUser = $user->fresh()->load('profile');

        return response()->json([
            'message' => 'Profil berhasil diperbarui!',
            'profile' => $updatedUser->profile,
        ]);
    }
}
