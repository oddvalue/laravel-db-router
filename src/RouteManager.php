<?php

namespace Oddvalue\DbRouter;

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
     * By default only the primary entity types have Routes
     *
     * @param \Oddvalue\DbRouter\Contracts\Routable $instance
     */
    public function updateRoutes(Routable $instance)
    {
        $this->deleteRoutes($instance);

        $generator = $instance->getRouteGenerator();

        if (! $generator->isRoutable($instance)) {
            return;
        }

        $this->addRoutes($instance);

        if ($generator instanceof ChildRouteGenerator) {
            $generator->getRouteChildren($instance)->map(function ($childInstance) {
                $this->updateRoutes($childInstance);
            });
        }
    }

    /**
     * Create new Route OR restore old path if already exists
     */
    public function addRoutes(Routable $instance)
    {
        try {
            $routes = collect($instance->getRouteGenerator()->getRoutes($instance));

            $canonicalRouteString = $routes->shift();
            $canonicalId = $this->createOrRestoreRoute($canonicalRouteString, $instance)->id;

            $routes->each(function ($route) use ($instance, $canonicalId) {
                $this->createOrRestoreRoute($route, $instance, $canonicalId);
            });
        } catch (QueryException $e) {
            throw RouteCollisionException::fromQueryException($e);
        }
    }

    public function createOrRestoreRoute(string $routeString, Routable $instance, int $canonicalId = null)
    {
        $type = get_class($instance);
        $type = Relation::getMorphedModel($type) ?? $type;
        Route::onlyTrashed()->whereHasMorph('routable', $type, function ($query) use ($instance) {
            $keyName = $instance->/** @scrutinizer ignore-call */getKeyName();
            $query->where($keyName, $instance->{$keyName});
        })->whereUrl($routeString)->forceDelete();

        $path = $instance->routes()->withTrashed()->firstOrCreate([
            'url' => $routeString,
            'canonical_id' => $canonicalId,
        ]);
        $path->restore();

        return $path;
    }

    /**
     * Delete existing Route instances for an entity
     */
    public function deleteRoutes(Routable $instance)
    {
        $instance->routes()->delete();

        $generator = $instance->getRouteGenerator();
        if ($generator instanceof ChildRouteGenerator) {
            $generator->getRouteChildren($instance)->map(function ($childInstance) {
                $this->deleteRoutes($childInstance);
            });
        }
    }

    /**
     * Create a redirect route
     *
     * @param string $url
     * @param self $route
     * @return Route
     */
    public static function createRedirect(string $url, Route $route) : Route
    {
        $redirect = new Route(['url' => $url]);
        $redirect->redirect()->associate($route);
        $redirect->save();
        return $redirect;
    }
}
