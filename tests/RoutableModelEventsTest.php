<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

class RoutableModelEventsTest extends TestCase
{
    protected $routableInstance;

    public function setUp() : void
    {
        parent::setUp();

        $this->routableInstance = Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);
    }

    public function testRouteCreation()
    {
        $dbRoute = Route::first();
        $expectedUrl = $dbRoute->parseUrl($this->routableInstance->getLinkGenerator()->href());
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
        $this->routableInstance->delete();
        $this->assertEquals(0, Route::count());
        $this->routableInstance->update(['name' => 'Bar']);
        $this->assertEquals(0, Route::count());
    }
}
