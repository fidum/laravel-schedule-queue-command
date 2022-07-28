<?php

namespace Fidum\LaravelScheduleQueueCommand\Tests;

use Fidum\LaravelScheduleQueueCommand\LaravelScheduleQueueCommandServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelScheduleQueueCommandServiceProvider::class,
        ];
    }
}
