<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Illuminate\Database\QueryException;
use Oddvalue\DbRouter\Contracts\Routeable;
use Oddvalue\DbRouter\Contracts\RouteGenerator;
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
     * @param Oddvalue\DbRouter\Contracts\Routeable $instance
     */
    public function updateRoutes(Routeable $instance)
    {
        $this->deleteRoutes($instance);

        $generator = $instance->getRouteGenerator();

        if (! $generator->isRouteable()) {
            return;
        }

        $this->addRoutes($instance);

        if ($generator instanceof ChildRouteGenerator) {
            $generator->getRouteChildren()->map(function ($childInstance) {
                $this->updateRoutes($childInstance);
            });
        }
    }

    /**
     * Create new Route OR restore old path if already exists
     */
    public function addRoutes(Routeable $instance)
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

    public function createOrRestoreRoute(string $routeString, Routeable $instance, int $canonicalId = null)
    {
        $type = get_class($instance);
        $type = Relation::getMorphedModel($type) ?? $type;
        Route::onlyTrashed()->whereHasMorph('routeable', $type, function ($query) use ($instance) {
            $query->where($instance->getKeyName(), $instance->id);
        })->whereUrl($routeString)->forceDelete();

        $generator = $instance->getRouteGenerator();
        $path = $instance->routes()->withTrashed()->firstOrCreate([
            'url' => $routeString,
            'canonical_id' => $canonicalId,
            'controller' => $generator->getRouteController(),
            'action' => $generator->getRouteAction(),
        ]);
        $path->restore();

        return $path;
    }

    /**
     * Delete existing Route instances for an entity
     */
    public function deleteRoutes(Routeable $instance)
    {
        $instance->routes()->delete();
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
