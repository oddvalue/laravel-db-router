# WIP: Backpack Media Library

This package is a work in progress and is not production ready.

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Upload and manage you media in Backpack for Laravel v4.

## Requirements

- Laravel 6.x
- Backpack 4.x
- Tested with PHP 7.3 but may work below

## Install

Via Composer

``` bash
$ composer require oddvalue/backpack-media-library
```

Publish and migrate

```bash
php artisan vendor:publish --provider "Oddvalue\BackpackMediaLibrary\BackpackMediaLibraryServiceProvider"
php artisan migrate
```

## Usage

First add the trait to the model you wish to attach media to:

```php
use Oddvalue\BackpackMediaLibrary\Traits\HasMedia;
```

Add relation methods to the model:

```php
public function gallery()
{
    return $this->hasManyMedia();
}

public function image()
{
    return $this->hasOneMedia();
}
```

Finally add fields to your model's CRUD controller:

```php
$this->crud->addField(MediaBrowserField::make('gallery'));
$this->crud->addField(MediaBrowserField::make('image')->single());
```

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

[ico-version]: https://img.shields.io/packagist/v/oddvalue/backpack-media-library.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/oddvalue/backpack-media-library/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/oddvalue/backpack-media-library.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/oddvalue/backpack-media-library.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/oddvalue/backpack-media-library.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/oddvalue/backpack-media-library
[link-travis]: https://travis-ci.org/oddvalue/backpack-media-library
[link-scrutinizer]: https://scrutinizer-ci.com/g/oddvalue/backpack-media-library/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/oddvalue/backpack-media-library
[link-downloads]: https://packagist.org/packages/oddvalue/backpack-media-library
[link-author]: https://github.com/oddvalue
[link-contributors]: ../../contributors
