<?php

namespace Laralabs\Menu\Tests;

use Laralabs\Menu\MenuServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MenuServiceProvider::class
        ];
    }
}
