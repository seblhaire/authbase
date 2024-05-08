<?php
namespace Seblhaire\Authbase\Traits;

use Illuminate\Support\Facades\Gate;
use Seblhaire\Authbase\Models\User;


trait GateTrait{
    public function boot() {

        Gate::define('is_admin', function ($user) {
            return $user->hasRole('administrator');
        });

        Gate::define('is_contributor', function ($user) {
            return $user->hasRole('contributor');
        });
    }
}