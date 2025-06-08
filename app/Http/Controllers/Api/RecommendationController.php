<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise; // <-- 1. Import Model Exercise
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    /**
     * Memberikan rekomendasi latihan berdasarkan target kalori yang ingin dibakar.
     */
    public function getWorkoutRecommendation(Request $request): JsonResponse
    {
        // Langkah 1: Validasi input dari pengguna
        $validated = $request->validate([
            'target_calories' => ['required', 'integer', 'min:10', 'max:2000'],
        ]);

        // Langkah 2: Ambil data pengguna yang sedang login beserta profilnya
        $user = Auth::user();
        $userWeight = $user->profile?->weight; // Menggunakan nullsafe operator (PHP 8+)

        // Cek apakah berat badan sudah diisi di profil
        if (!$userWeight) {
            return response()->json([
                'message' => 'Harap atur berat badan Anda di profil terlebih dahulu untuk mendapatkan rekomendasi.'
            ], 400); // 400 Bad Request
        }

        // Langkah 3: Ambil satu latihan secara acak dari "kamus" kita
        $exercise = Exercise::inRandomOrder()->first();

        // Cek jika tabel exercises ternyata kosong
        if (!$exercise) {
            return response()->json(['message' => 'Maaf, data latihan tidak tersedia.'], 404);
        }

        // Langkah 4: Lakukan kalkulasi menggunakan rumus MET
        // Kalori per Menit = (MET * Berat Badan (kg) * 3.5) / 200
        $caloriesPerMinute = ($exercise->met_value * $userWeight * 3.5) / 200;

        // Hindari error pembagian dengan nol jika hasil kalkulasi aneh
        if ($caloriesPerMinute <= 0) {
            return response()->json(['message' => 'Tidak dapat menghitung durasi untuk latihan ini.'], 500);
        }

        // Durasi yang dibutuhkan (menit) = Target Kalori / Kalori per Menit
        $requiredMinutes = $validated['target_calories'] / $caloriesPerMinute;

        // Langkah 5: Siapkan dan kirim response JSON yang informatif
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