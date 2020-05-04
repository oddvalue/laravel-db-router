<?php

namespace Oddvalue\DbRouter\Test\Routes;

use Illuminate\Support\Collection;
use Oddvalue\DbRouter\RouteGenerator;
use Oddvalue\DbRouter\Contracts\Routable;
use Oddvalue\DbRouter\Contracts\ChildRouteGenerator;

class ExampleRouteGenerator extends RouteGenerator implements ChildRouteGenerator
{
    public function getRoutes(Routable $instance)
    {
        $routes =  [
            $instance->getLinkGenerator()->href(),
        ];

        if ($instance->getNonCanonicalRoutePrefix()) {
            $routes[] = $instance->getLinkGenerator(['prefix' => $instance->getNonCanonicalRoutePrefix()])->href();
        }

        return $routes;
    }

    public function getRouteChildren(Routable $instance) : Collection
    {
        return $instance->children;
    }

    public function getRouteController() : string
    {
        return \Oddvalue\DbRouter\Test\Http\Controllers\ExampleController::class;
    }

    public function getRouteAction() : string
    {
        return 'show';
    }
}
