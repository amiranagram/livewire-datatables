<?php

namespace Amirami\LivewireDataTables\Tests\Browser;

use Amirami\LivewireDataTables\Tests\ConfiguresApplication;
use Amirami\LivewireDataTables\Tests\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Livewire\Component;
use Livewire\Macros\DuskBrowserMacros;
use Orchestra\Testbench\Dusk\Options as DuskOptions;
use Orchestra\Testbench\Dusk\TestCase as Orchestra;
use ReflectionException;

class TestCase extends Orchestra
{
    use ConfiguresApplication;

    /**
     * @return void
     * @throws ReflectionException
     */
    public function setUp(): void
    {
        if (isset($_SERVER['CI'])) {
            DuskOptions::withoutUI();
        }

        Browser::mixin(new DuskBrowserMacros());

        $this->afterApplicationCreated(function () {
            $this->cleanUp();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->cleanUp();
        });

        parent::setUp();

        $this->tweakApplication(function () {
            collect(File::allFiles(__DIR__ . '/../Components'))
                ->map(function ($file) {
                    $namespacePrefix = 'Amirami\\LivewireDataTables\\Tests\\Components\\';

                    return $namespacePrefix . Str::of($file->getRelativePathname())
                            ->before('.php')
                            ->replace('/', '\\');
                })
                ->filter(function ($computedClassName) {
                    return class_exists($computedClassName);
                })
                ->filter(function ($class) {
                    return is_subclass_of($class, Component::class);
                })->each(function ($componentClass) {
                    app('livewire')->component($componentClass);
                });

            Route::get('/livewire-dusk/{component}', function ($component) {
                $class = urldecode($component);

                return app()->call(new $class());
            })->middleware('web');

            app('session')->put('_token', 'this-is-a-hack-because-something-about-validating-the-csrf-token-is-broken');

            app('config')->set('view.paths', [
                __DIR__ . '/../views',
                resource_path('views'),
            ]);
        });
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->removeApplicationTweaks();

        parent::tearDown();
    }

    /**
     * @return void
     */
    public function cleanUp(): void
    {
        Artisan::call('view:clear');

        File::deleteDirectory($this->livewireViewsPath());
        File::cleanDirectory(__DIR__ . '/downloads');
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

        $app['config']->set('filesystems.disks.dusk-downloads', [
            'driver' => 'local',
            'root' => __DIR__ . '/downloads',
        ]);
    }
}
