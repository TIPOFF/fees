# Laravel Package for implementing Ecommerce fees

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tipoff/fees.svg?style=flat-square)](https://packagist.org/packages/tipoff/fees)
![Tests](https://github.com/tipoff/fees/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tipoff/fees.svg?style=flat-square)](https://packagist.org/packages/tipoff/fees)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require tipoff/fees
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Tipoff\Fees\FeesServiceProvider" --tag="fees-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Tipoff\Fees\FeesServiceProvider" --tag="fees-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$fees = new Tipoff\Fees();
echo $fees->echoPhrase('Hello, Tipoff!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Tipoff](https://github.com/tipoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
