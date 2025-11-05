# WIP: Laravel Database Routing

This package is a work in progress and is not production ready.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![CI][ico-ci]][link-ci]
[![Coverage][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

<!-- vscode-markdown-toc -->
* [Requirements](#Requirements)
* [Install](#Install)
* [Usage](#Usage)
	* [Preparing Your Model](#PreparingYourModel)
	* [Route Generators](#RouteGenerators)
* [Change log](#Changelog)
* [Testing](#Testing)
* [Contributing](#Contributing)
* [Security](#Security)
* [Credits](#Credits)
* [License](#License)

<!-- vscode-markdown-toc-config
	numbering=false
	autoSave=true
	/vscode-markdown-toc-config -->
<!-- /vscode-markdown-toc -->

This package allows you to set up dynamic routes for Laravel models in the database.

Features include:
- Automatically generate and store URLs for models in the database for dynamic routing.
- Remember old URLs and 301 redirect to the current one.
- Store multiple URLs with one as the main, canonical.
- Automatically update child page URLs when a parent's is updated.


## <a name='Requirements'></a>Requirements

- PHP >= 8.2
- Laravel 12.x
- [oddvalue/link-builder](https://github.com/oddvalue/link-builder) >= 2.0.0

## <a name='Install'></a>Install

Via Composer

``` bash
composer require oddvalue/laravel-db-router
```

Publish and migrate

``` bash
php artisan vendor:publish --provider "Oddvalue\DbRouter\DbRouterServiceProvider"
php artisan migrate
```

## <a name='Usage'></a>Usage

### <a name='PreparingYourModel'></a>Preparing Your Model

In order to use this package your model must implement the [`\Oddvalue\DbRouter\Contracts\Routable`](src/Contracts/Routable.php) interface.

Optionally, you may use the [`\Oddvalue\DbRouter\Traits\HasRoutes`](src/Traits/HasRoutes.php) trait to handle most of the interface implementation for you. Using the trait requires your model to have a `getRouteGeneratorClass` method that returns the fully qualified class name of the generator class for setting up the routes.

### <a name='RouteGenerators'></a>Route Generators

The route generator class is responsible for getting the URLs that a model is accessible from and what controller action should be performed when that URL is hit. Generators must implement the `\Oddvalue\DbRouter\Contracts\RouteGenerator` interface. There is also a `\Oddvalue\DbRouter\Contracts\ChildRouteGenerator` interface. Once implemented this will allow the package to also generate and update routes for child pages of your model.

### Using The Link Builder Package

The default implementation of the route generator uses [oddvalue/link-builder](https://github.com/oddvalue/link-builder) to generate

## <a name='Changelog'></a>Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## <a name='Testing'></a>Testing

``` bash
$ composer test
```

### Static analysis

Run PHPStan (with Larastan) at the highest level:

```bash
composer phpstan
```

## <a name='Contributing'></a>Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## <a name='Security'></a>Security

If you discover any security related issues, please email jim@oddvalue.co.uk instead of using the issue tracker.

## <a name='Credits'></a>Credits

- [Jim Hollington][link-author]
- [All Contributors][link-contributors]

## <a name='License'></a>License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/oddvalue/laravel-db-router.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://github.com/oddvalue/laravel-db-router/actions/workflows/ci.yml/badge.svg
[ico-downloads]: https://img.shields.io/packagist/dt/oddvalue/laravel-db-router.svg?style=flat-square
[ico-coverage]: https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/oddvalue/1b9a63d1adac98e446b9bb5b591d3e81/raw/95b3d3b66589d2625d205551c93b1dcf71ae4896/laravel-deb-router-coverage.json

[link-packagist]: https://packagist.org/packages/oddvalue/laravel-db-router
[link-ci]: https://github.com/oddvalue/laravel-db-router/actions/workflows/ci.yml
[link-coverage]: https://github.com/oddvalue/laravel-db-router/actions/workflows/ci.yml
[link-downloads]: https://packagist.org/packages/oddvalue/laravel-db-router
[link-author]: https://github.com/oddvalue
[link-contributors]: ../../contributors
