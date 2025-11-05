<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

beforeEach(function (): void {
    $this->routableInstance = Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);
});

it('creates a route for the model', function (): void {
    $dbRoute = Route::query()->first();
    $expectedUrl = $dbRoute->parseUrl($this->routableInstance->getLinkGenerator()->href());
    expect($dbRoute->url)->toBe($expectedUrl);
});

it('is accessible via HTTP', function (): void {
    $response = $this->get('foo');
    $response->assertStatus(200);
    $response->assertSeeText('Foo');
});

it('deletes routes when model is deleted and does not recreate on update', function (): void {
    $this->routableInstance->delete();
    expect(Route::query()->count())->toBe(0);
    $this->routableInstance->update(['name' => 'Bar']);
    expect(Route::query()->count())->toBe(0);
});
