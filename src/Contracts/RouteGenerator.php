<?php

namespace Oddvalue\DbRouter\Contracts;

use Oddvalue\DbRouter\Contracts\Routable;

interface RouteGenerator
{
    /**
     * Get all the urls that the instance should be accessible from
     *
     * @param \Oddvalue\DbRouter\Contracts\Routable $instance
     * @return array
     */
    public function getRoutes(Routable $instance) : array;

    /**
     * Should the model be available on the frontend
     *
     * @param \Oddvalue\DbRouter\Contracts\Routable $instance
     * @return boolean
     */
    public function isRoutable(Routable $instance) : bool;

    /**
     * Get the class name for the controller responsible for handling the route
     *
     * @param \Oddvalue\DbRouter\Contracts\Routable $instance
     * @return string
     */
    public function getRouteController(Routable $instance) : string;

    /**
     * Get the method name for handling the route
     *
     * @param \Oddvalue\DbRouter\Contracts\Routable $instance
     * @return string
     */
    public function getRouteAction(Routable $instance) : string;
}
