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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/livewire-datatables.php', 'livewire-datatables');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/livewire-datatables.php.php' => config_path('livewire-datatables.php'),
            ], 'livewire-datatables-config');
        }
    }
}
