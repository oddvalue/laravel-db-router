<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

class RouteableModelEventsTest extends TestCase
{
    protected $routeableInstance;

    public function setUp() : void
    {
        parent::setUp();

        $this->routeableInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
    }

    public function testRouteCreation()
    {
        $dbRoute = Route::first();
        $expectedUrl = $dbRoute->parseUrl($this->routeableInstance->getLinkGenerator()->href());
        $this->assertEquals($expectedUrl, $dbRoute->url);
    }

    public function testRouteAccessible()
    {
        $response = $this->get('foo');
        $response->assertStatus(200);
        $response->assertSeeText('Foo');
    }

    public function testRouteDeletion()
    {
        $this->routeableInstance->delete();
        $this->assertEquals(Route::count(), 0);
    }
}
