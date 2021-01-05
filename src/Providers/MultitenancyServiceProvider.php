<?php

namespace Aristides\Multitenancy\Providers;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Aristides\Multitenancy\Tenant\TenantManager;
use Aristides\Multitenancy\Providers\EventServiceProvider;
use Aristides\Multitenancy\Commands\TenantMigrationsCommand;
use Aristides\Multitenancy\Http\Middleware\TenantMiddleware;
use Aristides\Multitenancy\Http\Middleware\CheckDomainMainMiddleware;
use Aristides\Multitenancy\Http\Middleware\CheckTenantMiddleware;

class MultitenancyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'multitenancy');

        $this->configurePublishing();
        $this->configureCommands();
        $this->configureRoutes();
        $this->configureMiddlewares();
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);

        $this->app->bind('multitenancy', function($app) {
            return new TenantManager();
        });

        $this->mergeConfigFrom(__DIR__ . '/../../config/multitenancy.php', 'multitenancy');
    }

    protected function configurePublishing()
    {
        if ($this->app->runningInConsole()) {

            // Config file
            $this->publishes([
                __DIR__ . '/../../config/multitenancy.php' => config_path('multitenancy.php'),
            ], 'multitenancy-config');

            // Master migrations
            $migrationFileName = 'create_tenants_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'multitenancy-migrations');
            }

            // Tenants migrations
            $migrationTenantsFileName = '2014_10_12_000000_create_users_table.php';
            if (! $this->migrationTenantsFileExists($migrationTenantsFileName)) {
                $this->publishes([
                    __DIR__ . "/../../database/migrations/tenants" => database_path('migrations/tenants/'),
                ], 'multitenancy-tenants-migrations');
            }

            // Seeder
            $this->publishes([
                __DIR__ . "/../../database/seeder/TenantSeeder.php.stub" => database_path('seeders/TenantSeeder.php'),
            ], 'multitenancy-seeder');

            // Assets
            $this->publishes([
                __DIR__ . "/../../resources/assets" => public_path('vendor/multitenancy'),
            ], 'multitenancy-assets');

            // Views
            $this->publishes([
                __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/multitenancy'),
            ], 'multitenancy-views');
        }
    }

    protected function configureCommands()
    {
        $this->commands([
            TenantMigrationsCommand::class,
        ]);
    }

    public function configureRoutes()
    {
        $middlewares = config('multitenancy.middleware');
        array_push($middlewares, config('multitenancy.middleware_main'));

        Route::namespace('Aristides\Multitenancy\Http\Controllers')
            ->middleware($middlewares)
            ->prefix(config('multitenancy.prefix'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__. '/../routes/master.php');
            });
    }

    public function configureMiddlewares()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(TenantMiddleware::class);

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware(config('multitenancy.middleware_main'), CheckDomainMainMiddleware::class);
        $router->aliasMiddleware(config('multitenancy.middleware_tenant'), CheckTenantMiddleware::class);
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }

    public static function migrationTenantsFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/tenants/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
