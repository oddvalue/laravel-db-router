<?php

namespace Oddvalue\DbRouter;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DbRouterServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // publish the migrations and seeds
        $this->publishes([__DIR__.'/../database/migrations/' => database_path('migrations')], 'migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'dbrouter');
    }
}
