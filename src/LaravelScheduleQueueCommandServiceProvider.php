<?php

namespace Fidum\LaravelScheduleQueueCommand;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class LaravelScheduleQueueCommandServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Schedule::macro('queueCommand', function (
            string $command,
            array $parameters = [],
            ?string $queue = null,
            ?string $connection = null
        ) {
            $arguments = Container::getInstance()
                ->make(Request::class)
                ->server('argv') ?: [];

            /* @var Schedule $this */
            if (in_array('schedule:list', $arguments)) {
                return $this->command($command, $parameters);
            }

            return $this->call(function () use ($command, $parameters, $queue, $connection) {
                Container::getInstance()
                    ->make(Kernel::class)
                    ->queue($command, $parameters)
                    ->onQueue($queue)
                    ->onConnection($connection);
            })->description($command);
        });
    }
}
