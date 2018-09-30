<?php

namespace Sven\ArtisanShortcuts\Tests;

use Illuminate\Contracts\Console\Kernel;
use Sven\ArtisanShortcuts\ShortcutManager;

class ShortcutManagerTest extends TestCase
{
    /** @test */
    public function it_registers_a_shortcut()
    {
        /** @var \Illuminate\Contracts\Console\Kernel $artisan */
        $artisan = $this->app->get(Kernel::class);

        $manager = new ShortcutManager($artisan);

        $manager->add('clear', ['cache:clear', 'view:clear']);

        $this->assertArrayHasKey('clear', $artisan->all());
    }

    /** @test */
    public function it_can_register_multiple_shortcuts()
    {
        /** @var \Illuminate\Contracts\Console\Kernel $artisan */
        $artisan = $this->app->get(Kernel::class);

        $manager = new ShortcutManager($artisan);

        $manager->addMultiple([
            'clear' => ['cache:clear', 'view:clear'],
            'foo' => ['bar', 'baz'],
        ]);

        $this->assertArrayHasKey('clear', $artisan->all());
        $this->assertArrayHasKey('foo', $artisan->all());
    }
}
