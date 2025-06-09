<?php

namespace App\Policies;

use App\Models\FoodLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FoodLogPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, FoodLog $foodLog): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, FoodLog $foodLog): bool
    {
        return $user->id === $foodLog->user_id;
    }

    public function delete(User $user, FoodLog $foodLog): bool
    {   

        return $user->id === $foodLog->user_id;
    }

    public function restore(User $user, FoodLog $foodLog): bool
    {
        return false;
    }

    public function forceDelete(User $user, FoodLog $foodLog): bool
    {
        return false;
    }
}
