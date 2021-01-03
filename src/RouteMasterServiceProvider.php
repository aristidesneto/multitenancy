<?php

namespace Aristides\Multitenancy;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteMasterServiceProvider extends ServiceProvider
{
    public const HOME = '/admin';

    protected $namespace = 'Aristides\\Multitenancy\\Http\\Controllers';

    public function boot()
    {
        $this->routes(function () {
            Route::prefix('admin')
                ->middleware(['web', 'auth', 'check.domain.main'])
                ->namespace($this->namespace)
                ->group(__DIR__ . '/routes/master.php');

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(__DIR__ . '/routes/auth.php');
        });
    }
}
