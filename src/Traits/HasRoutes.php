<?php

namespace Oddvalue\DbRouter\Traits;

use Oddvalue\DbRouter\RouteManager;
use Oddvalue\DbRouter\Contracts\Routeable;
use Oddvalue\DbRouter\Contracts\RouteGenerator;

trait HasRoutes
{
    /**
     * Boot the trait
     *
     * @return void
     */
    public static function bootHasRoutes()
    {
        /**
         * Update routes after instance is saved
         */
        static::saved(function (Routeable $model) {
            $manager = new RouteManager;
            $manager->updateRoutes($model);
        });

        /**
         * Delete routes after instance is deleted
         */
        static::deleted(function (Routeable $model) {
            $manager = new RouteManager;
            $manager->deleteRoutes($model);
        });
    }

    abstract public function getRouteGeneratorClass();

    public function getRouteGenerator() : RouteGenerator
    {
        $generatorClass = $this->getRouteGeneratorClass();
        return new $generatorClass;
    }

    public function canonicalRoute()
    {
        return $this->morphOne(config('dbrouter.route_class'), 'routeable')->whereIsCanonical();
    }

    public function routes()
    {
        return $this->morphMany(config('dbrouter.route_class'), 'routeable');
    }

    public function redirectRoutes()
    {
        return $this->routes()->isRedirect();
    }
}
