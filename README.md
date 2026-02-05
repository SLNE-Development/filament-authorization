# Filament Authorization using policies and spatie-permissions

[![Latest Version on Packagist](https://img.shields.io/packagist/v/slne-development/filament-authorization.svg?style=flat-square)](https://packagist.org/packages/slne-development/filament-authorization)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/slne-development/filament-authorization/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/slne-development/filament-authorization/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/slne-development/filament-authorization/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/slne-development/filament-authorization/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/slne-development/filament-authorization.svg?style=flat-square)](https://packagist.org/packages/slne-development/filament-authorization)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small
example.

## Installation

You can install the package via composer:

```bash
composer require slne-development/filament-authorization
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-authorization-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-authorization-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-authorization-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentAuthorization = new SLNE\FilamentAuthorization();
echo $filamentAuthorization->echoPhrase('Hello, SLNE!');
```

Make sure to remove the default Authorization middlewares from middleware and
authorizationMiddleware.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security
vulnerabilities.

## Credits

- [Simon Homberg](https://github.com/SLNE-Development)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
