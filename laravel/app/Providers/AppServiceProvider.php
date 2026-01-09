<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-products', function (User $user) {
        return in_array($user->role, ['admin', 'manager']);
    });
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Gate::define('users.manage', function ($user) {
            return $user->hasPermission('users.manage');
        });

        Gate::define('products.create', function ($user) {
            return $user->hasPermission('products.create');
        });

        Gate::define('products.update', function ($user) {
            return $user->hasPermission('products.update');
        });

        Gate::define('categories.create', function ($user) {
            return $user->hasPermission('categories.create');
        });

        Gate::define('categories.update', function ($user) {
            return $user->hasPermission('categories.update');
        });
        
    }
}
