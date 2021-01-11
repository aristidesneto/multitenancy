<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Domain
    |--------------------------------------------------------------------------
    |
    | Este é o sub
    | This is the subdomain where Canvas will be accessible from. If the
    | domain is set to null, Canvas will reside under the defined base
    | path below. Otherwise, this will be used as the subdomain.
    |
    */
    'base_domain' => 'master.tenancy.test',

    'middleware_admin' => [
        'web',
        'auth'
    ],

    'middleware_tenant' => [
        'web',
        'auth'
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenants Prefix
    |--------------------------------------------------------------------------
    |
    | This is the tenant prefix where the system administrator
    | can manage all tenants
    |
    */
    'prefix' => 'tenants'

];
