# WIP: Laravel Database Routing

This package is a work in progress and is not production ready.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Upload and manage you media in Backpack for Laravel v4.

## Requirements

- Laravel >= 6.x
- PHP >= 7.3

## Install

Via Composer

``` bash
$ composer require oddvalue/laravel-db-router
```

Publish and migrate

```bash
php artisan vendor:publish --provider "Oddvalue\DbRouter\DbRouterServiceProvider"
php artisan migrate
```

## Usage

#TODO

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email jim@oddvalue.co.uk instead of using the issue tracker.

## Credits

- [Jim Hollington][link-author]
- [All Contributors][link-contributors]

## License

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
