<?php

namespace App\Policies;

use App\Models\Listeing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListeingPolicy
{
    public function before(?User $user, $ability)
    {
        if ($user && $user->is_admin) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listeing $listeing): bool
    {
        if ($user->id == $listeing->user_id) {
            return true;
        }

        return $listeing->sold_at == null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listeing $listeing): bool
    {
        return $listeing->user_id == $user->id && $listeing->sold_at == null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listeing $listeing): bool
    {
        return $listeing->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Listeing $listeing): bool
    {
        return $listeing->user_id == $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listeing $listeing): bool
    {
        return $listeing->user_id == $user->id;
    }
}
