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
use Aristides\Multitenancy\Commands\InstallMultitenancyCommand;
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
            $this->publishes([
                __DIR__ . '/../../config/multitenancy.php' => config_path('multitenancy.php'),
            ], 'multitenancy-config');
        }
    }

    protected function configureCommands()
    {
        $this->commands([
            InstallMultitenancyCommand::class,
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

        if (file_exists(base_path('routes/tenant.php'))) {
            $middlewares = config('multitenancy.middleware_tenant');
            array_push($middlewares, $this->middlewareTenant);

            Route::namespace('App\Http\Controllers\Tenants')
                ->middleware($middlewares)
                ->group(function () {
                    $this->loadRoutesFrom(base_path('routes/tenant.php'));
                });
        }
    }

    public function configureMiddlewares()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(TenantMiddleware::class);

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware($this->middlewareAdmin, CheckDomainMainMiddleware::class);
        $router->aliasMiddleware($this->middlewareTenant, CheckTenantMiddleware::class);
    }
}
