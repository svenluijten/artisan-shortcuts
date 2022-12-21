<?php

namespace Sven\ArtisanShortcuts\Tests;

use Illuminate\Cache\Console\ClearCommand;
use Illuminate\Contracts\Console\Kernel;
use Sven\ArtisanShortcuts\ServiceProvider;

class ShortcutsTest extends TestCase
{
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    protected $artisan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(ServiceProvider::class);
        $this->artisan = $this->app->get(Kernel::class);
    }

    /**
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->config->set('shortcuts.first', ['cache:clear', 'view:clear']);
        $app->config->set('shortcuts.second', ['key:generate' => ['--show' => true], 'view:clear']);
        $app->config->set('shortcuts.third', [ClearCommand::class, 'view:clear']);
    }

    /** @test */
    public function it_registers_the_shortcuts_as_commands()
    {
        $this->assertArrayHasKey('first', $this->artisan->all());
    }

    /** @test */
    public function it_calls_underlying_commands_when_a_shortcut_is_executed()
    {
        $this->artisan->call('first');

        $output = $this->artisan->output();

        $this->assertStringContainsString('cleared', $output);
        $this->assertStringContainsString('Compiled views cleared', $output);
    }

    /** @test */
    public function it_can_pass_options_and_parameters_to_underlying_commands()
    {
        touch(__DIR__.'/../vendor/orchestra/testbench-core/laravel/.env');

        $this->artisan->call('second');

        $output = $this->artisan->output();

        $this->assertStringContainsString('Compiled views cleared!', $output);
        $this->assertMatchesRegularExpression('/^base64:/i', $output);
    }
}
