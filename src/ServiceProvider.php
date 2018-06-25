<?php

namespace Sven\ArtisanShortcuts;

use Closure;
use Illuminate\Support\ServiceProvider as LaravelProvider;

class ServiceProvider extends LaravelProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/shortcuts.php' => config_path('shortcuts.php'),
        ], 'config');

        $shortcuts = collect(config('shortcuts', []));

        $shortcuts->each(function (array $definition, string $shortcut) {
            $this->app->get('artisan')->command(
                $shortcut, $this->commandClosure($definition)
            );
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shortcuts.php', 'shortcuts');
    }

    protected function commandClosure(array $definition): Closure
    {
        return function () use ($definition) {
            collect($definition)->each(function ($options, $command) {
                if (! is_array($options)) {
                    $command = $options;
                    $options = [];
                }

                $this->callSilent($command, $options);
            });
        };
    }
}
