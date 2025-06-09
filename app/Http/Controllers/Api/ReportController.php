<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class ReportController extends Controller
{
    public function getWeeklyReport(Request $request): JsonResponse
    {
        $user = Auth::user();

        $request->validate([
            'end_date' => 'sometimes|date_format:Y-m-d'
        ]);

        $endDate = $request->has('end_date') 
            ? Carbon::parse($request->input('end_date')) 
            : today();
        
        $startDate = $endDate->copy()->subDays(6); 

        $dailyFoodSummaries = $user->foodLogs()
            ->whereBetween('log_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(log_date) as date'),
                DB::raw('SUM(calories) as total_calories'),
                DB::raw('SUM(protein) as total_protein'),
                DB::raw('SUM(fat) as total_fat'),
                DB::raw('SUM(carbs) as total_carbs')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $dailyWorkoutSummaries = $user->workouts()
            ->whereBetween('log_date', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(log_date) as date'),
                DB::raw('SUM(calories_burned) as total_calories_burned'),
                DB::raw('SUM(duration_minutes) as total_duration')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        $averageCaloriesConsumed = $dailyFoodSummaries->avg('total_calories');
        $averageCaloriesBurned = $dailyWorkoutSummaries->avg('total_calories_burned');

        return response()->json([
            'report_period' => [
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ],
            'averages' => [
                'daily_calories_consumed' => round($averageCaloriesConsumed, 2),
                'daily_calories_burned' => round($averageCaloriesBurned, 2),
            ],
            'daily_summary' => [
                'food' => $dailyFoodSummaries,
                'workouts' => $dailyWorkoutSummaries,
            ]
        ]);
    }
}