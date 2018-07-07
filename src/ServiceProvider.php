<?php

namespace Sven\ArtisanShortcuts;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as LaravelProvider;

class ServiceProvider extends LaravelProvider
{
    protected $defer = true;

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/shortcuts.php' => config_path('shortcuts.php'),
        ], 'config');

        /** @var \Sven\ArtisanShortcuts\ShortcutManager $manager */
        $manager = $this->app->get('shortcuts.manager');

        $shortcuts = collect(config('shortcuts', []));

        foreach ($shortcuts as $shortcut => $definition) {
            $manager->add($shortcut, $definition);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shortcuts.php', 'shortcuts');

        $this->app->bind('shortcuts.manager', function (Application $app) {
            return new ShortcutManager($app->get(Kernel::class));
        });
    }
}
