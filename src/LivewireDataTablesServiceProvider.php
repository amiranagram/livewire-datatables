<?php

namespace Amirami\LivewireDataTables;

use Illuminate\Support\ServiceProvider;

class LivewireDataTablesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningUnitTests()) {
            $this->loadViewsFrom(__DIR__ . '/../tests/Browser', 'livewire-datatables');
        }
    }
}
