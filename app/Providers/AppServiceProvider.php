<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\FoodLog;       
use App\Models\Workout;       
use App\Policies\FoodLogPolicy; 
use App\Policies\WorkoutPolicy; 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        FoodLog::class => FoodLogPolicy::class, 
        Workout::class => WorkoutPolicy::class, 
    ];

    public function boot(): void
    {
        //
    }
}