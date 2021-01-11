<?php

namespace Aristides\Multitenancy\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Blade::if('tenant', function () {
            return request()->getHost() !== config('multitenancy.base_domain');
        });

        Blade::if('tenantmain', function () {
            return request()->getHost() === config('multitenancy.base_domain');
        });
    }
}
