<?php

use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\QueuedCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;

it('does not set the name when provided as a command signature', function () {
    Queue::fake();

    /** @var Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);

    /** @var CallbackEvent $event */
    $event = $scheduler->queueCommand('bar:run')->withoutOverlapping();
    expect($event->description)->toBe('bar:run');
});

it('sets the name from the command description when provided as a class string', function () {
    Queue::fake();

    /** @var Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);

    /** @var CallbackEvent $event */
    $event = $scheduler->queueCommand(FooCommand::class)->withoutOverlapping();

    expect($event->description)->toBe(FooCommand::class);
});

it('displays the command signature when you run artisan schedule:list', function () {
    Queue::fake();

    $this->app->make(Request::class)
        ->server
        ->set('argv', ['php', 'artisan', 'schedule:list']);

    /** @var Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);

    /** @var CallbackEvent $event */
    $scheduler->queueCommand(FooCommand::class)->everyMinute()->withoutOverlapping();

    $this->artisan('schedule:list')
        ->expectsOutputToContain('foo:run')
        ->assertSuccessful();
});

it('sends queued command to correct queue', function () {
    Queue::fake();

    /** @var Schedule $scheduler */
    $scheduler = $this->app->make(Schedule::class);
    $scheduler->queueCommand(FooCommand::class)->everyMinute();
    $scheduler->queueCommand('bar:test', ['foo' => 'bar'], 'test-queue')->everyMinute();
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
    $scheduler->queueCommand(FooCommand::class)->name('')->everyMinute()->withoutOverlapping();
    $scheduler->queueCommand(FooCommand::class, ['foo' => 'bar'], null, 'foo')->name('')->everyMinute();
    $scheduler->queueCommand('bar:test', ['foo' => 'bar'], null, 'bar')->name('')->everyMinute();

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

    protected $description = 'I am description for the foo command';

    public function handle()
    {
        //
    }
}
