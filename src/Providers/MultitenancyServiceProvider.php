<?php

namespace Aristides\Multitenancy\Providers;

use Illuminate\Routing\Router;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Aristides\Multitenancy\Tenant\TenantManager;
use Aristides\Multitenancy\Providers\BladeServiceProvider;
use Aristides\Multitenancy\Providers\EventServiceProvider;
use Aristides\Multitenancy\Commands\TenantMigrationsCommand;
use Aristides\Multitenancy\Http\Middleware\TenantMiddleware;
use Aristides\Multitenancy\Http\Middleware\CheckTenantMiddleware;
use Aristides\Multitenancy\Http\Middleware\CheckDomainMainMiddleware;
use Aristides\Multitenancy\Multitenancy;

class MultitenancyServiceProvider extends ServiceProvider
{
    private $middlewareAdmin = 'check.domain.main';

    private $middlewareTenant = 'check.tenant';

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
        $this->app->register(BladeServiceProvider::class);

        $this->app->bind('multitenancy', function($app) {
            return new Multitenancy();
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
            if (! $this->migrationFileExists($migrationTenantsFileName, 'tenants')) {
                $this->publishes([
                    __DIR__ . "/../../database/migrations/tenants" => database_path('migrations/tenants/'),
                ], 'multitenancy-migrations');
            }

            // Seeder
            $this->publishes([
                __DIR__ . "/../../database/seeder/DatabaseSeeder.php.stub" => database_path('seeders/DatabaseSeeder.php'),
            ], 'multitenancy-seeder');

            $this->publishes([
                __DIR__ . "/../../database/seeder/TenantSeeder.php.stub" => database_path('seeders/TenantSeeder.php'),
            ], 'multitenancy-seeder');

            $this->publishes([
                __DIR__ . "/../../database/seeder/UserSeeder.php.stub" => database_path('seeders/UserSeeder.php'),
            ], 'multitenancy-seeder');

            // Assets
            $this->publishes([
                __DIR__ . "/../../resources/assets" => public_path('vendor/multitenancy'),
            ], 'multitenancy-assets');

            // Views
            $this->publishes([
                __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/multitenancy'),
            ], 'multitenancy-views');

            // Routes
            $this->publishes([
                __DIR__. '/../routes/tenant.php.stub' => base_path('routes/tenant.php'),
            ], 'multitenancy-routes');

            // Controller App Tenant
            $this->publishes([
                __DIR__. '/../Http/Controllers/AppController.php.stub' => app_path('Http/Controllers/Tenants/AppController.php'),
            ], 'multitenancy-controller');

            // Model App Tenant
            $this->publishes([
                __DIR__. '/../Models/Tenants/Post.php.stub' => app_path('Models/Tenants/Post.php'),
            ], 'multitenancy-model');
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
        $middlewares = config('multitenancy.middleware_admin');
        array_push($middlewares, $this->middlewareAdmin);

        Route::namespace('Aristides\Multitenancy\Http\Controllers')
            ->middleware($middlewares)
            ->prefix(config('multitenancy.prefix'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__. '/../routes/master.php');
            });

        $middlewares = config('multitenancy.middleware_tenant');
        array_push($middlewares, $this->middlewareTenant);

        Route::namespace('Aristides\Multitenancy\Http\Controllers')
            ->middleware($middlewares)
            ->group(function () {
                $this->loadRoutesFrom(base_path('routes/tenant.php'));
            });
    }

    public function configureMiddlewares()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(TenantMiddleware::class);

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware($this->middlewareAdmin, CheckDomainMainMiddleware::class);
        $router->aliasMiddleware($this->middlewareTenant, CheckTenantMiddleware::class);
    }

    public static function migrationFileExists(string $migrationFileName, string $path = null) : bool
    {
        $len = strlen($migrationFileName);
        $path = $path === 'tenants' ? 'tenants/' : '';
        foreach (glob(database_path("migrations/{$path}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
