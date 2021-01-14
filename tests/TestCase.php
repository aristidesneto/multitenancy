<?php

namespace Aristides\Multitenancy\Tests;

use Aristides\Multitenancy\Providers\BladeServiceProvider;
use Aristides\Multitenancy\Providers\EventServiceProvider;
use Aristides\Multitenancy\Providers\MultitenancyServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Aristides\\Multitenancy\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            MultitenancyServiceProvider::class,
            EventServiceProvider::class,
            BladeServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        include_once __DIR__ . '/../database/migrations/tenants/create_posts_table.php.stub';
        (new \CreatePostsTable)->up();

        include_once __DIR__ . '/../database/migrations/create_tenants_table.php.stub';
        (new \CreateTenantsTable)->up();
    }
}
