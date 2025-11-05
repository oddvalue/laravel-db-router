<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

beforeEach(function () {
    Example::make([
        'name' => 'Foo',
        'slug' => 'foo',
    ])->setNonCanonicalRoutePrefix('bar')->save();
});

it('scopes canonical routes', function () {
    expect(Route::whereIsCanonical()->count())->toBe(1);
});

it('determines routes are canonical', function () {
    $count = Route::all()->filter(function ($route) {
        return $route->isCanonical();
    })->count();

    expect($count)->toBe(1);
});

it('relates canonical and non-canonical correctly', function () {
    $expectedNonCanonicalUrl = '/bar/foo';
    $expectedCanonicalUrl = '/foo';

    $nonCanonicalRoute = Route::all()->first(function ($route) {
        return $route->isCanonical();
    });

    expect($nonCanonicalRoute->url)->toBe($expectedNonCanonicalUrl);
    expect($nonCanonicalRoute->canonical->url)->toBe($expectedCanonicalUrl);
});
