<?php

namespace Seblhaire\Authbase\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AuthbaseServiceProvider extends ServiceProvider {

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'authbase');
        $this->publishes([
            __DIR__ . '/../../config/authbase.php' => config_path('authbase.php'),
            __DIR__ . '/../../resources/views/public' => resource_path('views/vendor/authbase/public'),
            __DIR__ . '/../../lang' => app()->langPath('vendor/authbase'),
        ]);
        //$this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        //$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'authbase');
        Blade::anonymousComponentPath(__DIR__ . '/../../resources/components', 'authbase');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/authbase.php', 'authbase');
    }

    public function provides() {
        // return [PasswordResetServiceProvider::class];
    }
}
