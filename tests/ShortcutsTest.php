<?php

namespace Sven\ArtisanShortcuts\Tests;

use GrahamCampbell\TestBenchCore\MockeryTrait;
use Illuminate\Contracts\Console\Kernel;
use Sven\ArtisanShortcuts\ShortcutManager;

class ShortcutsTest extends TestCase
{
    use MockeryTrait;

    /** @test */
    public function it_registers_the_shortcut_as_a_command()
    {
        /** @var \Illuminate\Contracts\Console\Kernel $artisan */
        $artisan = $this->app->get(Kernel::class);

        $manager = new ShortcutManager($artisan);

        $manager->add('clear', ['cache:clear', 'view:clear']);

        $this->assertArrayHasKey('clear', $artisan->all());
    }
}
