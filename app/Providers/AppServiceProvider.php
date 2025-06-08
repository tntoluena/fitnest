<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\FoodLog;       // <-- Tambahkan jika belum ada
use App\Models\Workout;       // <-- 1. IMPORT MODEL WORKOUT
use App\Policies\FoodLogPolicy; // <-- Tambahkan jika belum ada
use App\Policies\WorkoutPolicy; // <-- 2. IMPORT WORKOUT POLICY
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        FoodLog::class => FoodLogPolicy::class, // <-- Anda mungkin sudah punya ini
        Workout::class => WorkoutPolicy::class, // <-- 3. DAFTARKAN POLICY DI SINI
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}