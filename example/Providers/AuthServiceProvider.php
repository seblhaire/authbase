<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Policies\UserPolicy;
use Seblhaire\Authbase\Traits\GateTrait;

class AuthServiceProvider extends ServiceProvider {
    use GateTrait;

    protected $policies = [
        User::class => UserPolicy::class,
    ];
    
}
