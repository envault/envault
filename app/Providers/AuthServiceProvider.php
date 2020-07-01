<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\\Policies\\'.class_basename($modelClass).'Policy';
        });

        Gate::define('administrate', function (User $user) {
            return $user->isAdminOrOwner();
        });
    }
}
