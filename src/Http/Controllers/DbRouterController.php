<?php

namespace Oddvalue\DbRouter\Http\Controllers;

use Oddvalue\DbRouter\Route;
use Illuminate\Routing\Controller;
use Oddvalue\DbRouter\Contracts\Routable;

class DbRouterController extends Controller
{
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

        return app()->call([$controller, $action], [
            'model' => $routableInstance,
        ]);
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
