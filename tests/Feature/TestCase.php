<?php

namespace Amirami\LivewireDataTables\Tests\Feature;

use Amirami\LivewireDataTables\Tests\ConfiguresApplication;
use Amirami\LivewireDataTables\Tests\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use ConfiguresApplication;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->cleanUp();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->cleanUp();
        });

        parent::setUp();
    }

    /**
     * @return void
     */
    public function cleanUp(): void
    {
        Artisan::call('view:clear');

        File::deleteDirectory($this->livewireViewsPath());
        File::deleteDirectory($this->livewireClassesPath());
        File::delete(app()->bootstrapPath('cache/livewire-components.php'));
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('view.paths', [
            __DIR__ . '/../views',
            resource_path('views'),
        ]);

        $app['config']->set('app.key', 'base64:gFcRjIFTHVIQ458sZwdcBvPPVnAKdW2+CRYS2x17nyk=');
        $app['config']->set('app.debug', true);

        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('auth.providers.users.model', User::class);
    }
}
