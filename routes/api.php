<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Api\FoodLogController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\WorkoutController; 
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rute-rute di sini akan otomatis memiliki prefix /api.
|
*/

// --- RUTE PUBLIK (Tidak Perlu Token) ---
// Nama metode di controller adalah 'store', bukan 'login' atau 'register'
Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);


// --- Grup untuk semua rute yang memerlukan autentikasi token ---
Route::middleware('auth:sanctum')->group(function () {

    // Rute default untuk mendapatkan data user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rute untuk logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    
    // Rute untuk Food Log Pengguna
    Route::post('/food-logs', [FoodLogController::class, 'store']); 
    Route::get('/food-logs', [FoodLogController::class, 'index']);
    Route::put('/food-logs/{food_log}', [FoodLogController::class, 'update']);
    Route::delete('/food-logs/{food_log}', [FoodLogController::class, 'destroy']);

    // --- RUTE UNTUK DASHBOARD ---
    Route::get('/dashboard/summary', [DashboardController::class, 'getSummary']);
    Route::get('/dashboard/recommendations', [DashboardController::class, 'getRecommendations']);

    // --- RUTE BARU UNTUK WORKOUT LOG ---
    // Endpoint untuk menyimpan (Create) catatan workout baru
    Route::post('/workouts', [WorkoutController::class, 'store']);
    Route::get('/workouts', [WorkoutController::class, 'index']);
    Route::put('/workouts/{workout}', [WorkoutController::class, 'update']);
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy']);

    Route::get('/reports/weekly', [ReportController::class, 'getWeeklyReport']);
});
