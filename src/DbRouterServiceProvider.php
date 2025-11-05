<?php

namespace Oddvalue\DbRouter;

use Illuminate\Support\ServiceProvider;

class DbRouterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        // publish the migrations and seeds
        $this->publishes([__DIR__.'/../database/migrations/' => database_path('migrations')], 'migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'dbrouter');
    }
}
