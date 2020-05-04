<?php

namespace Oddvalue\DbRouter\Http\Controllers;

use Oddvalue\DbRouter\Route;
use Illuminate\Routing\Controller;
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

        $controller = app($route->controller);

        $parameters = $this->resolveClassMethodDependencies([$route->routable], $controller, $route->action);

        if (method_exists($controller, 'callAction')) {
            return $controller->callAction($route->action, $parameters);
        }

        return $controller->{$route->action}(...array_values($parameters));
    }

    protected function redirect($route)
    {
        if (! $route->shouldRedirect()) {
            throw new NotFoundHttpException("No route for url '{$url}'");
        }

        return redirect($route->redirect_url, 301);
    }
}
