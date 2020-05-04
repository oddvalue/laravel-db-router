<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Contracts\Routable;
use Oddvalue\DbRouter\Contracts\RouteGenerator as RouteGeneratorContract;

abstract class RouteGenerator implements RouteGeneratorContract
{
    public function getRoutes(Routable $instance)
    {
        return [$instance->getLinkGenerator()->href()];
    }

    abstract public function getRouteController() : string;

    abstract public function getRouteAction() : string;
}
