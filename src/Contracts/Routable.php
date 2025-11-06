<?php

namespace Oddvalue\DbRouter\Contracts;

use Oddvalue\DbRouter\Route;
use Oddvalue\LinkBuilder\Contracts\Linkable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property-read Route|null $canonicalRoute
 */
interface Routable extends Linkable
{
    /**
     * Get the model's route generator
     */
    public function getRouteGenerator() : RouteGenerator;

    /**
     * Relation to the canonical route for the model
     *
     * @return MorphOne<Route, $this>
     */
    public function canonicalRoute() : MorphOne;

    /**
     * Relation to all the model's routes
     *
     * @return MorphMany<Route, $this>
     */
    public function routes() : MorphMany;

    /**
     * Relation to all the model's redirect routes
     *
     * @return MorphMany<Route, $this>
     */
    public function redirectRoutes() : MorphMany;
}
