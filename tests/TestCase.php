<?php

namespace Sven\ArtisanShortcuts\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sven\ArtisanShortcuts\ServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
