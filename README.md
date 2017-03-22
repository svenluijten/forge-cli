![:package](:hero)

# Package

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Code Climate][ico-codeclimate]][link-codeclimate]
[![Code Quality][ico-quality]][link-quality]
[![SensioLabs Insight][ico-insight]][link-insight]

Short description of the package. What does it do and why should people download
it? Brag a bit but don't exaggerate. Talk about what's to come and tease small
pieces of functionality.

> :namespace
> :package
> :insight
> :hero

## Installation
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/:package
```

Or add the package to your dependencies in `composer.json` and run
`composer install` on the command line to download the package:

```json
{
    "require": {
        "sven/:package": "*"
    }
}
```

> Is this a Laravel package?

Next, add the `ServiceProvider` to your `providers` array in `config/app.php`:

```php
'providers' => [
    ...
    Sven\:namespace\ServiceProvider::class,
];
```

If you would like to load this package in certain environments only, take a look
at [sven/env-providers](https://github.com/svenluijten/env-providers).

## Usage
Some examples of the code. How should people use it, what options does this package
provide? Should people be wary of some functionality?

```php
Maybe some code?
```

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/:package` is licensed under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/:package.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/:package.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/svenluijten/:package.svg?style=flat-square
[ico-codeclimate]: https://img.shields.io/codeclimate/github/svenluijten/:package.svg?style=flat-square
[ico-quality]: https://img.shields.io/scrutinizer/g/svenluijten/:package.svg?style=flat-square
[ico-insight]: https://img.shields.io/sensiolabs/i/:insight.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/sven/:package
[link-downloads]: https://packagist.org/packages/sven/:package
[link-travis]: https://travis-ci.org/svenluijten/:package
[link-codeclimate]: https://codeclimate.com/github/svenluijten/:package
[link-quality]: https://scrutinizer-ci.com/g/svenluijten/:package/?branch=master
[link-insight]: https://insight.sensiolabs.com/projects/:insight
