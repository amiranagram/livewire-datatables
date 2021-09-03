<?php

namespace Amirami\LivewireDataTables\Tests;

use Amirami\LivewireDataTables\LivewireDataTablesServiceProvider;
use Livewire\LivewireServiceProvider;

trait ConfiguresApplication
{
    /**
     * @param string $path
     * @return string
     */
    protected function livewireClassesPath(string $path = ''): string
    {
        return app_path('Http/Livewire' . ($path ? '/' . $path : ''));
    }

    /**
     * @param string $path
     * @return string
     */
    protected function livewireViewsPath(string $path = ''): string
    {
        return resource_path('views') . '/livewire' . ($path ? '/' . $path : '');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            LivewireDataTablesServiceProvider::class,
        ];
    }
}
