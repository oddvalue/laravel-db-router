<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\RouteCollisionException;

class RouteCollisionTest extends TestCase
{
    public function testRouteCollision()
    {
        $this->expectException(RouteCollisionException::class);

        Example::create([
            'name' => 'Foo',
            'slug' => 'foo',
        ]);

        Example::create([
            'name' => 'Bar',
            'slug' => 'foo',
        ]);
    }
}
