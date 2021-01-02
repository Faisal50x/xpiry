# A simple tool can make your expire validation easier and faster.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/faisal50x/xpiry.svg?style=flat-square)](https://packagist.org/packages/faisal50x/xpiry)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/faisal50x/xpiry/run-tests?label=tests)](https://github.com/faisal50x/xpiry/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/faisal50x/xpiry.svg?style=flat-square)](https://packagist.org/packages/faisal50x/xpiry)


This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require faisal50x/xpiry
```

## Usage

```php
use Faisal50x\Xpiry\Xpiry;
echo Xpiry::make('2021-11-14', '1 month')
  	 ->startOf('month');
#2021-12-01 00:00:00
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

- [Faisal Ahmed](https://github.com/Faisal50x)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
