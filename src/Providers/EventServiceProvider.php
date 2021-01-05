<?php

namespace Aristides\Multitenancy\Providers;

use Aristides\Multitenancy\Events\TenantCreate;
use Aristides\Multitenancy\Listeners\TenantCreateDatabase;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TenantCreate::class => [
            TenantCreateDatabase::class,
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
