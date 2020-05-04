<?php

namespace Oddvalue\DbRouter\Traits;

use Oddvalue\DbRouter\RouteManager;
use Oddvalue\DbRouter\Contracts\Routeable;
use Oddvalue\DbRouter\Contracts\RouteGenerator;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    /**
     * Should the model be available on the frontend
     *
     * @return boolean
     */
    abstract public function isRouteable() : bool;

    /**
     * Get the fully qualified class name of the model's route generator
     *
     * @return string
     */
    abstract public function getRouteGeneratorClass() : string;

    /**
     * Get the model's route generator
     *
     * @return \Oddvalue\DbRouter\Contracts\RouteGenerator
     */
    public function getRouteGenerator() : RouteGenerator
    {
        $generatorClass = $this->getRouteGeneratorClass();
        return new $generatorClass;
    }

    /**
     * Relation to the canonical route for the model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function canonicalRoute() : MorphOne
    {
        return $this->morphOne(config('dbrouter.route_class'), 'routeable')->whereIsCanonical();
    }

    /**
     * Relation to all the model's routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function routes() : MorphMany
    {
        return $this->morphMany(config('dbrouter.route_class'), 'routeable');
    }

    /**
     * Relation to all the model's redirect routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function redirectRoutes() : MorphMany
    {
        return $this->routes()->isRedirect();
    }
}
