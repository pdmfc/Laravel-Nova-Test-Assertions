<?php

namespace Pdmfc\NovaTestAssertions\Tests;

use Mockery;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaServiceProvider;
use Illuminate\Foundation\Application;
use Laravel\Nova\NovaCoreServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Contracts\Auth\Authenticatable;
use Pdmfc\NovaTestAssertions\Traits\NovaTestAssertions;
use Pdmfc\NovaTestAssertions\Tests\Fixtures\UserResource;

abstract class TestCase extends Orchestra
{
    use NovaTestAssertions;

    public function setup(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->withFactories(__DIR__ . '/Factories');
        $this->registerResources();
        Nova::auth(static function () {
            return true;
        });
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    public function registerResources(): void
    {
        Nova::$tools = [];
        Nova::$resources = [];

        Nova::resources([
            UserResource::class,
        ]);
    }

    /**
     * Get the service providers for the package.
     *
     * @param  Application  $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            NovaCoreServiceProvider::class,
            NovaServiceProvider::class,
        ];
    }

    /**
     * Authenticate as an anonymous user.
     *
     * @return $this
     */
    protected function authenticate(): self
    {
        $this->actingAs($this->authenticatedAs = Mockery::mock(Authenticatable::class));

        $this->authenticatedAs->shouldReceive('getAuthIdentifier')->andReturn(1);
        $this->authenticatedAs->shouldReceive('getKey')->andReturn(1);

        return $this;
    }
}
