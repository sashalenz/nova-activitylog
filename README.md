# nova-activitylog
Laravel Nova ActivityLog resource tool based on spatie/laravel-activitylog 

## Requirements

This Nova field requires Nova 2 and spatie/laravel-activitylog

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

And you can optionally publish the localization files with:

```bash
php artisan vendor:publish --provider="Sashalenz\NovaActivitylog\ToolServiceProvider" --tag="translations"
```

## Usage

```php
// in app/Providers/NovaServiceProvder.php

// ...

public function tools()
{
    return [
        // ...
        new \Sashalenz\NovaActivitylog\NovaActivitylog(),
    ];
}
```
## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
