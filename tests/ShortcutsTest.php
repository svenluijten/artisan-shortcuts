<?php

namespace Sven\ArtisanShortcuts\Tests;

use GrahamCampbell\TestBenchCore\MockeryTrait;
use Mockery as m;

class ShortcutsTest extends TestCase
{
    use MockeryTrait;

    /** @test */
    function it_calls_commands_it_is_configured_to_call()
    {
        $this->app['config']->set('shortcuts.foo', ['bar']);

        $mock = m::mock(\Illuminate\Foundation\Console\Kernel::class)
            ->makePartial()
            ->shouldReceive('call')
            ->with('bar', [])
            ->getMock();

        $this->app->instance(\Illuminate\Contracts\Console\Kernel::class, function () use ($mock) {
            return $mock;
        });

        $this->app->get(\Illuminate\Contracts\Console\Kernel::class)->call('foo');
    }
}
