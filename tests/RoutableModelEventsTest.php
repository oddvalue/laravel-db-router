<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\Test\Models\Example;

beforeEach(function () {
    $this->routableInstance = Example::create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);
});

it('creates a route for the model', function () {
    $dbRoute = Route::first();
    $expectedUrl = $dbRoute->parseUrl($this->routableInstance->getLinkGenerator()->href());
    expect($dbRoute->url)->toBe($expectedUrl);
});

it('is accessible via HTTP', function () {
    $response = $this->get('foo');
    $response->assertStatus(200);
    $response->assertSeeText('Foo');
});

it('deletes routes when model is deleted and does not recreate on update', function () {
    $this->routableInstance->delete();
    expect(Route::count())->toBe(0);
    $this->routableInstance->update(['name' => 'Bar']);
    expect(Route::count())->toBe(0);
});
