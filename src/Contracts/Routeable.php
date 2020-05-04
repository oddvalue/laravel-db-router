<?php

namespace Oddvalue\DbRouter\Contracts;

use Oddvalue\LinkBuilder\Contracts\Linkable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Routeable extends Linkable
{
    /**
     * Should the model be available on the frontend
     *
     * @return boolean
     */
    public function isRouteable() : bool;

    /**
     * Get the model's route generator
     *
     * @return \Oddvalue\DbRouter\Contracts\RouteGenerator
     */
    public function getRouteGenerator() : RouteGenerator;

    /**
     * Relation to the canonical route for the model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function canonicalRoute() : MorphOne;

    /**
     * Relation to all the model's routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function routes() : MorphMany;

    /**
     * Relation to all the model's redirect routes
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function redirectRoutes() : MorphMany;
}
