<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Contracts\Routeable;
use Oddvalue\DbRouter\Contracts\RouteGenerator as RouteGeneratorContract;

abstract class RouteGenerator implements RouteGeneratorContract
{
    public function getRoutes(Routeable $instance)
    {
        return [$instance->getLinkGenerator()->href()];
    }

    abstract public function getRouteController() : string;

    abstract public function getRouteAction() : string;
}
