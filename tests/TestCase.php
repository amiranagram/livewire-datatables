<?php

namespace Amirami\LivewireDataTables\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Amirami\LivewireDataTables\LivewireDataTablesServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireDataTablesServiceProvider::class,
        ];
    }
}
