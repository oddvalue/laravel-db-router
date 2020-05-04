# WIP: Laravel Database Routing

This package is a work in progress and is not production ready.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

<!-- vscode-markdown-toc -->
* 1. [Requirements](#Requirements)
* 2. [Install](#Install)
* 3. [Usage](#Usage)
	* 3.1. [Preparing Your Model](#PreparingYourModel)
	* 3.2. [Route Generators](#RouteGenerators)
* 4. [Change log](#Changelog)
* 5. [Testing](#Testing)
* 6. [Contributing](#Contributing)
* 7. [Security](#Security)
* 8. [Credits](#Credits)
* 9. [License](#License)

<!-- vscode-markdown-toc-config
	numbering=true
	autoSave=true
	/vscode-markdown-toc-config -->
<!-- /vscode-markdown-toc -->

This package allows you to set up dynamic routes for Laravel models in the database.

Features include:
- Automatically generate and store URLs for models in the database for dynamic routing.
- Remember old URLs and 301 redirect to the current one.
- Store multiple URLs with one as the main, canonical.
- Automatically update child page URLs when a parent's is updated.


##  1. <a name='Requirements'></a>Requirements

- PHP >= 7.3
- Laravel >= 6.x
- [oddvalue/link-builder](https://github.com/oddvalue/link-builder) >= 1.0.0

##  2. <a name='Install'></a>Install

Via Composer

``` bash
composer require oddvalue/laravel-db-router
```

Publish and migrate

``` bash
php artisan vendor:publish --provider "Oddvalue\DbRouter\DbRouterServiceProvider"
php artisan migrate
```

##  3. <a name='Usage'></a>Usage

###  3.1. <a name='PreparingYourModel'></a>Preparing Your Model

In order to use this package your model must implement the [`\Oddvalue\DbRouter\Contracts\Routable`](src/Contracts/Routable.php) interface.

Optionally, you may use the [`\Oddvalue\DbRouter\Traits\HasRoutes`](src/Traits/HasRoutes.php) trait to handle most of the interface implementation for you. Using the trait requires your model to have a `getRouteGeneratorClass` method that returns the fully qualified class name of the generator class for setting up the routes.

###  3.2. <a name='RouteGenerators'></a>Route Generators

The route generator class is responsible for getting the URLs that a model is accessible from and what controller action should be performed when that URL is hit. Generators must implement the `\Oddvalue\DbRouter\Contracts\RouteGenerator` interface. There is also a `\Oddvalue\DbRouter\Contracts\ChildRouteGenerator` interface. Once implemented this will allow the package to also generate and update routes for child pages of your model.

##  4. <a name='Changelog'></a>Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

##  5. <a name='Testing'></a>Testing

``` bash
$ composer test
```

##  6. <a name='Contributing'></a>Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

##  7. <a name='Security'></a>Security

If you discover any security related issues, please email jim@oddvalue.co.uk instead of using the issue tracker.

##  8. <a name='Credits'></a>Credits

- [Jim Hollington][link-author]
- [All Contributors][link-contributors]

##  9. <a name='License'></a>License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/oddvalue/laravel-db-router.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/oddvalue/laravel-db-router/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/oddvalue/laravel-db-router.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/oddvalue/laravel-db-router.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oddvalue/laravel-db-router.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/oddvalue/laravel-db-router
[link-travis]: https://travis-ci.org/oddvalue/laravel-db-router
[link-scrutinizer]: https://scrutinizer-ci.com/g/oddvalue/laravel-db-router/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/oddvalue/laravel-db-router
[link-downloads]: https://packagist.org/packages/oddvalue/laravel-db-router
[link-author]: https://github.com/oddvalue
[link-contributors]: ../../contributors
