<?php

namespace Amirami\LivewireDataTables\Tests;

use Amirami\LivewireDataTables\LivewireDataTablesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireDataTablesServiceProvider::class,
        ];
    }
}
