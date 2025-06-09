<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function getSummary(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'sometimes|date_format:Y-m-d'
        ]);

        $logDate = $request->input('date', now()->toDateString());
        $user = Auth::user();

        $foodLogsForDate = $user->foodLogs()
                              ->whereDate('log_date', $logDate)
                              ->get();

        $caloriesConsumed = $foodLogsForDate->sum('calories');
        $proteinConsumed = $foodLogsForDate->sum('protein');
        $fatConsumed = $foodLogsForDate->sum('fat');
        $carbsConsumed = $foodLogsForDate->sum('carbs');

        $caloriesBurned = $user->workouts()
                             ->whereDate('log_date', $logDate)
                             ->sum('calories_burned');

        $netCalories = $caloriesConsumed - $caloriesBurned;

        return response()->json([
            'date' => $logDate,
            'summary' => [
                'calories_consumed' => (int) $caloriesConsumed,
                'calories_burned'   => (int) $caloriesBurned,
                'net_calories'      => (int) $netCalories,
                'protein_consumed'  => (float) $proteinConsumed,
                'fat_consumed'      => (float) $fatConsumed,
                'carbs_consumed'    => (float) $carbsConsumed,
                'calorie_goal'      => $user->profile->calorie_goal ?? 0,
            ]
        ]);
    }

    public function getRecommendations(Request $request): JsonResponse
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile || !$profile->calorie_goal) {
            return response()->json(['message' => 'Harap atur target kalori Anda di profil terlebih dahulu.'], 400);
        }

        $caloriesConsumed = $user->foodLogs()
                                ->whereDate('log_date', now()->toDateString())
                                ->sum('calories');

        $remainingCalories = $profile->calorie_goal - $caloriesConsumed;

        if ($remainingCalories <= 0) {
            return response()->json([
                'message' => 'Target kalori harian Anda sudah terpenuhi!',
                'recommendations' => []
            ]);
        }

        $sortBy = $request->input('sort_by', 'random');
        $mealType = $request->input('meal_type');

        $query = Food::where('calories', '<=', $remainingCalories);

        if ($mealType) {
            $query->where('meal_type', 'like', '%' . $mealType . '%');
        }

        if (in_array($sortBy, ['protein', 'carbs', 'fat', 'calories'])) {
            $query->orderBy($sortBy, 'desc');
        } else {
            $query->inRandomOrder();
        }

        $recommendations = $query->limit(5)->get();
        
        return response()->json([
            'remaining_calories' => (int) $remainingCalories,
            'recommendations' => $recommendations
        ]);
    }
}