<?php

use Oddvalue\DbRouter\Route;
use Oddvalue\DbRouter\RouteManager;
use Oddvalue\DbRouter\Test\Models\Example;
use Oddvalue\DbRouter\Exceptions\NoRedirectUrlException;

it('redirects trashed routes to updated slug', function (): void {
    $exampleInstance = Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);
    $exampleInstance->update([
        'slug' => 'bar',
    ]);
    $response = $this->get('/foo');
    $response->assertRedirect('/bar');
});

it('redirects a manual redirect route to canonical', function (): void {
    $exampleInstance = Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);
    RouteManager::createRedirect('/bar', $exampleInstance->canonicalRoute);
    $response = $this->get('/bar');
    $response->assertRedirect('/foo');
});

it('throws when accessing redirect_url on non-redirect route', function (): void {
    $exampleInstance = Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);

    expect(fn () => $exampleInstance->canonicalRoute->redirect_url)
        ->toThrow(NoRedirectUrlException::class);
});

it('scopes redirect routes correctly', function (): void {
    $exampleInstance = Example::query()->create([
        'name' => 'Foo',
        'slug' => 'foo',
    ]);
    $exampleInstance->update([
        'slug' => 'bar',
    ]);

    RouteManager::createRedirect('/baz', $exampleInstance->canonicalRoute);

    // Assert counts
    expect(Route::query()->count())->toBe(2);
    expect(Route::withTrashed()->count())->toBe(3);
    expect(Route::isRedirect()->count())->toBe(2);
    expect($exampleInstance->redirectRoutes()->count())->toBe(1);
});
