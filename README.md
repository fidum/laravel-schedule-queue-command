# Provides the ability to queue commands from the Laravel scheduler.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fidum/laravel-schedule-queue-command.svg?style=for-the-badge)](https://packagist.org/packages/fidum/laravel-schedule-queue-command)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/fidum/laravel-schedule-queue-command./Tests?label=tests&style=for-the-badge)](https://github.com/fidum/laravel-schedule-queue-command/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Codecov](https://img.shields.io/codecov/c/github/fidum/laravel-schedule-queue-command?logo=codecov&logoColor=white&style=for-the-badge)](https://codecov.io/gh/fidum/laravel-schedule-queue-command)
[![Twitter Follow](https://img.shields.io/twitter/follow/danmasonmp?label=Follow&logo=twitter&style=for-the-badge)](https://twitter.com/danmasonmp)

Provides the ability to queue commands from the Laravel scheduler.

## Installation

You can install the package via composer:

```bash
composer require fidum/laravel-schedule-queue-command
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-schedule-queue-command-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-schedule-queue-command-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-schedule-queue-command-views"
```

## Usage

```php
$laravelScheduleQueueCommand = new Fidum\LaravelScheduleQueueCommand();
echo $laravelScheduleQueueCommand->echoPhrase('Hello, Fidum!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/dmason30/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniel Mason](https://github.com/dmason30)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
