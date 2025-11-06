<?php

namespace Oddvalue\DbRouter;

use Illuminate\Database\Eloquent\Model;
use Oddvalue\DbRouter\Route;
use Illuminate\Database\QueryException;
use Oddvalue\DbRouter\Contracts\Routable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Oddvalue\DbRouter\Contracts\ChildRouteGenerator;
use Oddvalue\DbRouter\Exceptions\RouteCollisionException;

class RouteManager
{
    /**
     * If the slug has changed then softdelete current path for self and all
     * descendants and insert new path for self and all descendants
     */
    public function updateRoutes(Routable $instance): void
    {
        $this->deleteRoutes($instance);

        $generator = $instance->getRouteGenerator();

        if (! $generator->isRoutable($instance)) {
            return;
        }

        $this->addRoutes($instance);

        if ($generator instanceof ChildRouteGenerator) {
            $generator->getRouteChildren($instance)->map(function (Routable $childInstance): void {
                $this->updateRoutes($childInstance);
            });
        }
    }

    /**
     * Create new Route OR restore old path if already exists
     */
    public function addRoutes(Routable $instance): void
    {
        try {
            $routes = collect($instance->getRouteGenerator()->getRoutes($instance));

            $canonicalRouteString = $routes->shift();

            if ($canonicalRouteString === null) {
                return;
            }

            $canonicalId = $this->createOrRestoreRoute($canonicalRouteString, $instance)->id;

            $routes->each(function (string $route) use ($instance, $canonicalId): void {
                $this->createOrRestoreRoute($route, $instance, $canonicalId);
            });
        } catch (QueryException $e) {
            throw RouteCollisionException::fromQueryException($e);
        }
    }

    public function createOrRestoreRoute(string $routeString, Routable $instance, ?int $canonicalId = null): Route
    {
        $type = $instance::class;
        $type = Relation::getMorphedModel($type) ?? $type;
        Route::onlyTrashed()->whereHasMorph('routable', $type, function ($query) use ($instance): void {
            /** @var Model&Routable $model */
            $model = $instance;
            $keyName = $model->/** @scrutinizer ignore-call */getKeyName();
            $query->where($keyName, $model->{$keyName});
        })->whereUrl($routeString)->forceDelete();

        $routes = $instance->routes();
        $path = $routes->withTrashed()->firstOrCreate([
            'url' => $routeString,
            'canonical_id' => $canonicalId,
        ]);
        $path->restore();

        return $path;
    }

    /**
     * Delete existing Route instances for an entity
     */
    public function deleteRoutes(Routable $instance): void
    {
        $instance->routes()->delete();

        $generator = $instance->getRouteGenerator();
        if ($generator instanceof ChildRouteGenerator) {
            $generator->getRouteChildren($instance)->map(function (Routable $childInstance): void {
                $this->deleteRoutes($childInstance);
            });
        }
    }

    /**
     * Create a redirect route
     */
    public static function createRedirect(string $url, Route $route) : Route
    {
        $redirect = new Route(['url' => $url]);
        $redirect->redirect()->associate($route);
        $redirect->save();
        return $redirect;
    }
}
