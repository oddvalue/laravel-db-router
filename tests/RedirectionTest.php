<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\RouteManager;
use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\NoRedirectUrlException;

class RedirectionTest extends TestCase
{
    public function testTrashedRouteRedirect()
    {
        $exampleInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
        $exampleInstance->update([
            'slug' => 'bar',
        ]);
        $response = $this->get('/foo');
        $response->assertRedirect('/bar');
    }

    public function testRedirectRoute()
    {
        $exampleInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
        RouteManager::createRedirect('/bar', $exampleInstance->canonicalRoute);
        $response = $this->get('/bar');
        $response->assertRedirect('/foo');
    }

    public function testNoRedirectException()
    {
        $this->expectException(NoRedirectUrlException::class);

        $exampleInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
        $exampleInstance->canonicalRoute->redirect_url;
    }

    public function testIsRedirectScope()
    {
        $exampleInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
        $exampleInstance->update([
            'slug' => 'bar',
        ]);

        RouteManager::createRedirect('/baz', $exampleInstance->canonicalRoute);

        // Assert that there are 2 routes in the database
        $this->assertEquals(2, Route::count());
        // Assert that there are 3 routes in the database including trashed
        $this->assertEquals(3, Route::withTrashed()->count());
        // Assert that 2 of those 3 routes are redirects
        $this->assertEquals(2, Route::isRedirect()->count());
        // Assert that the example instance has 1 redirect route related to it
        $this->assertEquals(1, $exampleInstance->redirectRoutes()->count());
    }
}
