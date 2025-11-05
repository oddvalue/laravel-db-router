<?php

namespace Oddvalue\DbRouter\Contracts;

use Oddvalue\DbRouter\Contracts\Routable;

interface RouteGenerator
{
    /**
     * Get all the urls that the instance should be accessible from
     *
     * @return array<int, string>
     */
    public function getRoutes(Routable $instance) : array;

    /**
     * Should the model be available on the frontend
     */
    public function isRoutable(Routable $instance) : bool;

    /**
     * Get the class name for the controller responsible for handling the route
     */
    public function getRouteController(Routable $instance) : string;

    /**
     * Get the method name for handling the route
     */
    public function getRouteAction(Routable $instance) : string;
}
