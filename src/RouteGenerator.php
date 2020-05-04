<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Contracts\Routable;
use Oddvalue\DbRouter\Contracts\RouteGenerator as RouteGeneratorContract;

abstract class RouteGenerator implements RouteGeneratorContract
{
    public function getRoutes(Routable $instance) : array
    {
        return [$instance->getLinkGenerator()->href()];
    }

    abstract public function getRouteController(Routable $instance) : string;

    abstract public function getRouteAction(Routable $instance) : string;
}
