<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise; // <-- 1. Import Model Exercise
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    
    public function getWorkoutRecommendation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'target_calories' => ['required', 'integer', 'min:10', 'max:2000'],
        ]);

        $user = Auth::user();
        $userWeight = $user->profile?->weight; 

        if (!$userWeight) {
            return response()->json([
                'message' => 'Harap atur berat badan Anda di profil terlebih dahulu untuk mendapatkan rekomendasi.'
            ], 400); // 400 Bad Request
        }

        $exercise = Exercise::inRandomOrder()->first();

        if (!$exercise) {
            return response()->json(['message' => 'Maaf, data latihan tidak tersedia.'], 404);
        }

        $caloriesPerMinute = ($exercise->met_value * $userWeight * 3.5) / 200;

        if ($caloriesPerMinute <= 0) {
            return response()->json(['message' => 'Tidak dapat menghitung durasi untuk latihan ini.'], 500);
        }

        $requiredMinutes = $validated['target_calories'] / $caloriesPerMinute;

        return response()->json([
            'target_calories' => (int) $validated['target_calories'],
            'user_weight_kg'  => (float) $userWeight,
            'recommendation'  => [
                'exercise' => [
                    'name'      => $exercise->name,
                    'type'      => $exercise->type,
                    'met_value' => (float) $exercise->met_value,
                ],
                'calories_burned_per_minute' => round($caloriesPerMinute, 2),
                'required_duration_minutes'  => round($requiredMinutes, 2),
            ]
        ]);
    }
}