<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Auth\Access\Response;

class WorkoutPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Workout $workout): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Workout $workout): bool
    {
    return $user->id === $workout->user_id;
    }

    public function delete(User $user, Workout $workout): bool
    {
    return $user->id === $workout->user_id;
    }

    public function restore(User $user, Workout $workout): bool
    {
        return false;
    }

    public function forceDelete(User $user, Workout $workout): bool
    {
        return false;
    }
}
