<?php

namespace Oddvalue\DbRouter\Test\Routes;

use Oddvalue\DbRouter\RouteGenerator;
use Oddvalue\DbRouter\Contracts\Routeable;

class ExampleRouteGenerator extends RouteGenerator
{
    public function getRoutes(Routeable $instance)
    {
        $routes =  [
            $instance->getLinkGenerator()->href(),
        ];

        if ($instance->getNonCanonicalRoutePrefix()) {
            $routes[] = $instance->getLinkGenerator(['prefix' => $instance->getNonCanonicalRoutePrefix()])->href();
        }

        return $routes;
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
