<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

beforeEach(function (): void {
    Example::query()->make([
        'name' => 'Foo',
        'slug' => 'foo',
    ])->setNonCanonicalRoutePrefix('bar')->save();
});

it('scopes canonical routes', function (): void {
    expect(Route::whereIsCanonical()->count())->toBe(1);
});

it('determines routes are canonical', function (): void {
    $count = Route::all()->filter(fn($route): bool => $route->isCanonical())->count();

    expect($count)->toBe(1);
});

it('relates canonical and non-canonical correctly', function (): void {
    $expectedNonCanonicalUrl = '/bar/foo';
    $expectedCanonicalUrl = '/foo';

    $nonCanonicalRoute = Route::all()->first(fn($route): bool => $route->isCanonical());

    expect($nonCanonicalRoute->url)->toBe($expectedNonCanonicalUrl);
    expect($nonCanonicalRoute->canonical->url)->toBe($expectedCanonicalUrl);
});
