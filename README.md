# Provides the ability to queue commands from the Laravel scheduler.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/fidum/laravel-schedule-queue-command.svg?style=for-the-badge)](https://packagist.org/packages/fidum/laravel-schedule-queue-command)
[![GitHub Workflow Status (with branch)](https://img.shields.io/github/actions/workflow/status/fidum/laravel-schedule-queue-command/run-tests.yml?branch=main&style=for-the-badge)](https://github.com/fidum/laravel-schedule-queue-command/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Twitter Follow](https://img.shields.io/badge/follow-%40danmasonmp-1DA1F2?logo=twitter&style=for-the-badge)](https://twitter.com/danmasonmp)

Adds a `queueCommand` function to the scheduler that executes the equivalent of `Artisan::queue(...)` on the given schedule. It also provides the ability to optionally customise the `queue` and `connection` if needed.

## Installation

You can install the package via composer:

```bash
composer require fidum/laravel-schedule-queue-command
```

## Usage
In your laravel projects `app/Console/Kernel.php`:
```php
$schedule->queueCommand(FooCommand::class)->everyMinute();
$schedule->queueCommand(FooCommand::class, ['some-argument' => 'foo']);
$schedule->queueCommand(FooCommand::class, ['some-argument' => 'foo'], 'queue');
$schedule->queueCommand(FooCommand::class, ['some-argument' => 'foo'], 'queue', 'connection');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/dmason30/.github/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Daniel Mason](https://github.com/dmason30)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
