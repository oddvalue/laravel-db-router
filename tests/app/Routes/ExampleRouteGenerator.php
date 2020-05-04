<?php

namespace Oddvalue\DbRouter\Test\Routes;

use Illuminate\Support\Collection;
use Oddvalue\DbRouter\RouteGenerator;
use Oddvalue\DbRouter\Contracts\Routable;
use Oddvalue\DbRouter\Contracts\ChildRouteGenerator;

class ExampleRouteGenerator extends RouteGenerator implements ChildRouteGenerator
{
    public function getRoutes(Routable $instance) : array
    {
        $routes = parent::getRoutes($instance);

        if ($instance->getNonCanonicalRoutePrefix()) {
            $routes[] = $instance->getLinkGenerator(['prefix' => $instance->getNonCanonicalRoutePrefix()])->href();
        }

        return $routes;
    }

    public function isRoutable(Routable $instance) : bool
    {
        return ! $instance->trashed();
    }

    public function getRouteChildren(Routable $instance) : Collection
    {
        return $instance->children;
    }

    public function getRouteController(Routable $instance) : string
    {
        return \Oddvalue\DbRouter\Test\Http\Controllers\ExampleController::class;
    }

    public function getRouteAction(Routable $instance) : string
    {
        return 'show';
    }
}
