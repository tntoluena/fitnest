<?php

namespace App\Policies;

use App\Models\FoodLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FoodLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FoodLog $foodLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, FoodLog $foodLog): bool
    {
        // Izinkan update HANYA JIKA user_id di catatan makanan
        // sama dengan id pengguna yang sedang melakukan request.
        return $user->id === $foodLog->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FoodLog $foodLog): bool
    {   
    // Izinkan hapus HANYA JIKA user_id di catatan makanan
    // sama dengan id pengguna yang sedang melakukan request.
        return $user->id === $foodLog->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, FoodLog $foodLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, FoodLog $foodLog): bool
    {
        return false;
    }
}
