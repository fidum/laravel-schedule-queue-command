<?php

namespace Fidum\LaravelScheduleQueueCommand;

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\ServiceProvider;

class LaravelScheduleQueueCommandServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Schedule::macro('queueCommand', function (
            /** @var class-string<Command> $command */
            string $command,
            array $parameters = [],
            ?string $queue = null,
            ?string $connection = null
        ) {
            /** @var Schedule $this */
            return $this->call(function () use ($command, $parameters, $queue, $connection) {
                Container::getInstance()
                    ->make(Kernel::class)
                    ->queue($command, $parameters)
                    ->onQueue($queue)
                    ->onConnection($connection);
            });
        });
    }
}
