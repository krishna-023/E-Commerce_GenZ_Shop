<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Super-admin Gate
        Gate::define('super-admin', function ($user) {
            return $user->role === 'super-admin';
        });

        // Admin Gate
        Gate::define('admin', function ($user) {
            return $user->role === 'admin' || $user->role === 'super-admin';
        });

        // User Gate
        Gate::define('user', function ($user) {
            return $user->role === 'user' || $user->role === 'admin' || $user->role === 'super-admin';
        });
    }
}
