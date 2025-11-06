<?php

namespace Oddvalue\DbRouter\Http\Controllers;

use RuntimeException;
use Illuminate\Routing\Controller;
use Oddvalue\DbRouter\Contracts\Routable;
use Oddvalue\DbRouter\Route;

class DbRouterController extends Controller
{
    public function __invoke(string $url): mixed
    {
        return $this->resolveRoute("/$url");
    }

    protected function resolveRoute(string $url): mixed
    {
        $route = Route::whereUrl($url)->withTrashed()->firstOrFail();

        if ($route->shouldRedirect()) {
            return $this->redirect($route);
        }

        $routableInstance = $route->routable;

        abort_unless($routableInstance !== null, 404, 'Route has no associated model');

        $action = $this->getRouteAction($routableInstance);

        return $this->callControllerAction($action, $routableInstance);
    }

    protected function redirect(Route $route): mixed
    {
        return redirect($route->redirect_url, 301);
    }

    /**
     * @return array{0: object, 1: string}
     */
    protected function getRouteAction(Routable $routableInstance): array
    {
        $generator = $routableInstance->getRouteGenerator();
        $controller = app($generator->getRouteController($routableInstance));

        throw_unless(is_object($controller), RuntimeException::class, 'Controller must be an object');

        return [
            $controller,
            $generator->getRouteAction($routableInstance),
        ];
    }

    /**
     * @param array{0: object, 1: string} $callable
     */
    protected function callControllerAction(array $callable, Routable $model): mixed
    {
        /** @phpstan-ignore argument.type */
        return app()->call($callable, [
            'model' => $model,
        ]);
    }
}
