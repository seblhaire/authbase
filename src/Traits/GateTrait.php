<?php
namespace Seblhaire\Authbase\Traits;


trait GateTrait{
    public function boot() {

        Gate::define('is_admin', function ($user) {
            return $user->hasRole('administrator');
        });

        Gate::define('is_contributor', function ($user) {
            return $user->hasRole('contributor');
        });
        Gate::policy(User::class, UserPolicy::class);
    }
}