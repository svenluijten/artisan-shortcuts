<?php

namespace Sven\ArtisanShortcuts;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as LaravelProvider;

class ServiceProvider extends LaravelProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/shortcuts.php' => config_path('shortcuts.php'),
        ], 'config');

        /** @var \Sven\ArtisanShortcuts\ShortcutManager $manager */
        $manager = $this->app->get('shortcuts.manager');

        $manager->addMultiple($this->app['config']->get('shortcuts', []));
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shortcuts.php', 'shortcuts');

        $this->app->bind('shortcuts.manager', function (Application $app) {
            return new ShortcutManager($app->get(Kernel::class));
        });
    }
}
