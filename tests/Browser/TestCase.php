<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\LivewireDataTablesServiceProvider;
use Orchestra\Testbench\Dusk\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireDataTablesServiceProvider::class,
        ];
    }
}
