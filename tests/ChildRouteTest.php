<?php

namespace Oddvalue\DbRouter;

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\RouteCollisionException;

class ChildRouteTest extends TestCase
{
    public function testChildRouteUpdating()
    {
        $parentInstance = Example::create([
            'name' => 'Parent',
            'slug' => 'parent',
        ]);
        $childInstance = $parentInstance->children()->create([
            'name' => 'Child',
            'slug' => 'child',
        ]);
        $parentInstance->load('children');

        // Test that the child route contains the parent
        $expected = '/parent/child';
        $actual = $childInstance->canonicalRoute()->first()->url;
        $this->assertEquals($expected, $actual);

        $parentInstance->update([
            'slug' => 'updated-parent',
        ]);

        // Test that the child route was automatically updated when the parent was updated
        $expected = '/updated-parent/child';
        $actual = $childInstance->canonicalRoute()->first()->url;
        $this->assertEquals($expected, $actual);

        $parentInstance->delete();

        // Test that deleting the parent deletes the child routes
        $expected = 0;
        $actual = Route::count();
        $this->assertEquals($expected, $actual);
    }
}
