<?php

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\QueuedCommand;
use Illuminate\Support\Facades\Queue;

it('sends queued command to correct queue', function () {
    Queue::fake();

    /** @var Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);
    $scheduler->queueCommand(FooCommand::class)->name('')->everyMinute();
    $scheduler->queueCommand(FooCommand::class, ['foo' => 'bar'], 'test-queue')->name('')->everyMinute();
    $scheduler->queueCommand(FooCommand::class, ['foo' => 'bar'], 'another-queue')->name('')->everyMinute();

    $events = $scheduler->events();
    foreach ($events as $event) {
        $event->run($this->app);
    }

    Queue::assertPushedOn('test-queue', QueuedCommand::class);
    Queue::assertPushedOn('another-queue', QueuedCommand::class);
    Queue::assertPushedOn(null, QueuedCommand::class);
});

it('sends queued command to correct connection', function () {
    Queue::fake();

    /** @var \Illuminate\Console\Scheduling\Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);
    $scheduler->queueCommand(FooCommand::class)->name('')->everyMinute();
    $scheduler->queueCommand(FooCommand::class, ['foo' => 'bar'], null, 'foo')->name('')->everyMinute();
    $scheduler->queueCommand(FooCommand::class, ['foo' => 'bar'], null, 'bar')->name('')->everyMinute();

    $events = $scheduler->events();
    foreach ($events as $event) {
        $event->run($this->app);
    }

    Queue::assertPushed(fn (QueuedCommand $job) => $job->connection === null, 1);
    Queue::assertPushed(fn (QueuedCommand $job) => $job->connection === 'foo', 1);
    Queue::assertPushed(fn (QueuedCommand $job) => $job->connection === 'bar', 1);
});

class FooCommand extends Command
{
    protected $signature = 'foo:run';

    public function handle()
    {
        //
    }
}
