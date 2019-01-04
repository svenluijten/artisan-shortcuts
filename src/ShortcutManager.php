<?php

namespace Sven\ArtisanShortcuts;

use Illuminate\Contracts\Console\Kernel;

class ShortcutManager
{
    /**
     * @var \Illuminate\Foundation\Console\Kernel
     */
    private $app;

    public function __construct(Kernel $app)
    {
        $this->app = $app;
    }

    public function add(string $name, array $definition): void
    {
        $this->app->command($name, $this->commandClosure($definition));
    }

    public function addMultiple(array $shortcuts): void
    {
        foreach ($shortcuts as $shortcut => $definition) {
            $this->add($shortcut, $definition);
        }
    }

    protected function commandClosure(array $definition): callable
    {
        return function () use ($definition) {
            collect($definition)->each(function ($options, $command) {
                if (! \is_array($options)) {
                    $command = $options;
                    $options = [];
                }

                $this->call($command, $options);
            });
        };
    }
}
