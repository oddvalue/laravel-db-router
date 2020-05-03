<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

class CanonicalTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();

        Example::make([
            'name' => 'Foo',
            'slug' => 'foo',
        ])->setNonCanonicalRoutePrefix('bar')->save();
    }

    public function testCanonicalScope()
    {
        $expectedCanonicalCount = 1;
        $actualCanonicalCount = Route::whereIsCanonical()->count();

        $this->assertEquals($expectedCanonicalCount, $actualCanonicalCount);
    }

    public function testIsCanonical()
    {
        $expectedCount = 1;
        $actualNonCanonicalRouteCount = Route::all()->filter(function ($route) {
            return $route->isCanonical();
        })->count();

        $this->assertEquals($expectedCount, $actualNonCanonicalRouteCount);
    }

    public function testCanonicalRelation()
    {
        $expectedNonCanonicalUrl = '/bar/foo';
        $expectedCanonicalUrl = '/foo';

        $nonCanonicalRoute = Route::all()->first(function ($route) {
            return $route->isCanonical();
        });

        $this->assertEquals($expectedNonCanonicalUrl, $nonCanonicalRoute->url);
        $this->assertEquals($expectedCanonicalUrl, $nonCanonicalRoute->canonical->url);
    }
}
