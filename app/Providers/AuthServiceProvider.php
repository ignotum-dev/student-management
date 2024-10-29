<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('index-student', function (User $current_user, User $user) {
            return $current_user->id === $user->id;
        });

        Gate::define('store-student', function (User $current_user, User $user) {
            return $current_user->id === $user->id;
        });

        Gate::define('show-student', function (User $current_user, User $user) {
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
        });
    }
}
