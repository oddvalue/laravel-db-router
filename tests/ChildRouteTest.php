<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

it('updates child routes when parent changes and cleans up on delete', function () {
    $parentInstance = Example::create([
        'name' => 'Parent',
        'slug' => 'parent',
    ]);
    $childInstance = $parentInstance->children()->create([
        'name' => 'Child',
        'slug' => 'child',
    ]);
    $parentInstance->load('children');

    // child contains parent in URL
    expect($childInstance->canonicalRoute()->first()->url)->toBe('/parent/child');

    $parentInstance->update([
        'slug' => 'updated-parent',
    ]);

    // child updated when parent updated
    expect($childInstance->canonicalRoute()->first()->url)->toBe('/updated-parent/child');

    $parentInstance->delete();

    // deleting parent deletes child routes
    expect(Route::count())->toBe(0);
});
