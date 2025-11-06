<?php

use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\RouteCollisionException;

it('throws route collision when creating duplicate slug', function (): void {
    Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);

    expect(fn () => Example::query()->create([
        'name' => 'Bar',
        'slug' => 'foo',
    ]))->toThrow(RouteCollisionException::class);
});
