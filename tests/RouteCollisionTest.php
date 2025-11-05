<?php

use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\RouteCollisionException;

it('throws route collision when creating duplicate slug', function () {
    Example::create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);

    expect(fn () => Example::create([
        'name' => 'Bar',
        'slug' => 'foo',
    ]))->toThrow(RouteCollisionException::class);
});
