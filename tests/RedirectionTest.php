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

        $this->assertEquals(2, Route::count());
        $this->assertEquals(3, Route::withTrashed()->count());
        $this->assertEquals(2, Route::isRedirect()->count());
    }
}
