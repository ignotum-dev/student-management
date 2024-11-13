<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Log;
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
            if (in_array($user->role_id, [1, 2]) || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isAdmin()) {
            if (in_array($user->role_id, [1, 2, 3]) || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isSuperAdmin()) {
            if (in_array($user->role_id, [1, 2, 3, 4, 5]) || $current_user->id === $user->id) {
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
        if ($user->isStudent()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $current_user, User $user)
    {
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
            if (in_array($user->role_id, [1, 2]) || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isAdmin()) {
            if (in_array($user->role_id, [1, 2, 3]) || $current_user->id === $user->id) {
                return true;
            } else {
                return false;
            }
        } elseif ($current_user->isSuperAdmin()) {
            if (in_array($user->role_id, [1, 2, 3, 4, 5])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
