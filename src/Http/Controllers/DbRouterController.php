<?php

namespace Oddvalue\DbRouter\Http\Controllers;

use Oddvalue\DbRouter\Route;
use Illuminate\Routing\Controller;
use Oddvalue\DbRouter\Contracts\Routable;
use Illuminate\Routing\RouteDependencyResolverTrait;

class DbRouterController extends Controller
{
    use RouteDependencyResolverTrait;

    public function __invoke($url)
    {
        return $this->resolveRoute("/$url");
    }

    protected function resolveRoute($url)
    {
        $route = Route::whereUrl($url)->withTrashed()->firstOrFail();

        if ($route->shouldRedirect()) {
            return $this->redirect($route);
        }

        $routableInstance = $route->routable;
        [$controller, $action] = $this->getRouteAction($routableInstance);

        $parameters = $this->resolveClassMethodDependencies([$routableInstance], $controller, $action);

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($action, $parameters);
        }

        return $controller->{$action}(...array_values($parameters));
    }

    protected function redirect($route)
    {
        return redirect($route->redirect_url, 301);
    }

    protected function getRouteAction(Routable $routableInstance)
    {
        $generator = $routableInstance->getRouteGenerator();
        return [
            app($generator->getRouteController($routableInstance)),
            $generator->getRouteAction($routableInstance),
        ];
    }
}
