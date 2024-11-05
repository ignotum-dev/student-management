<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        if ($user->isStudent()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $current_user, User $user)
    {
        // return [$current_user, $user];
        if ($current_user->isStudent()) {
            if ($current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isProgramChair()) {
            if ($user->role_id === 1 || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isDean()) {
            if ($user->role_id === 1 || $user->role_id === 2 || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isAdmin()) {
            if ($user->role_id === 1 || $user->role_id === 2 || $user->role_id === 3 || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isSuperAdmin()) {
            if ($user->role_id === 1 || $user->role_id === 2 || $user->role_id === 3 || $user->role_id === 4 || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        if(!$user->isStudent()) {
            return $user->id;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $current_user, User $user)
    {
        if ($current_user->isStudent()) {
            return $current_user->id === $user->id;
        }

        if ($current_user->isProgramChair()) {
            return $user->role_id === 1 || $current_user->id === $user->id;
        }

        if ($current_user->isDean()) {
            return $user->role_id === 1 || $user->role_id === 2 || $current_user->id === $user->id;
        }

        if ($current_user->isAdmin()) {
            return $user->role_id === 1 || $user->role_id === 2 || $user->role_id === 3 || $current_user->id === $user->id;
        }

        if ($current_user->isSuperAdmin()) {
            return $user->role_id === 1 || $user->role_id === 2 ||$user->role_id === 3 ||$user->role_id === 4 ||
            $user->role_id === 5;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        //
    }
}
