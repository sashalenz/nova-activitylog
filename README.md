# Nova tool for activity log
Laravel Nova tool for a monitoring the users' activity based on `spatie/laravel-activitylog`. 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/palpalani/nova-activitylog.svg?style=flat-square)](https://packagist.org/packages/palpalani/nova-activitylog)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/palpalani/nova-activitylog/run-tests?label=tests)](https://github.com/palpalani/nova-activitylog/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/palpalani/nova-activitylog/Check%20&%20fix%20styling?label=code%20style)](https://github.com/palpalani/nova-activitylog/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/palpalani/nova-activitylog.svg?style=flat-square)](https://packagist.org/packages/palpalani/nova-activitylog)

## Requirements

Requires Laravel Nova 3 and `spatie/laravel-activitylog`.

## Installation

You can install the package into a Laravel app that uses Nova via composer:

```bash
composer require sashalenz/nova-activitylog
```

You can publish the migration for creating extra field named "request" with:

```bash
php artisan vendor:publish --provider="Sashalenz\NovaActivitylog\ToolServiceProvider" --tag="migrations"
```

After publishing the migration you can update existed activity_log table by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Sashalenz\NovaActivitylog\ToolServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'store-request' => true,
];
```

You can optionally publish the localization files with:

```bash
php artisan vendor:publish --provider="Sashalenz\NovaActivitylog\ToolServiceProvider" --tag="translations"
```

## Usage

```php
// in app/Providers/NovaServiceProvider.php

// ...

public function tools()
{
    return [
        // ...
        new \Sashalenz\NovaActivitylog\NovaActivitylog(),
    ];
}
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

- [palPalani](https://github.com/palpalani)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
