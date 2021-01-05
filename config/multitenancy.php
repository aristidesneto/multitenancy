<?php

return [

    'domain_main' => 'master.tenancy.test',

    'middleware' => [
        'web',
        'auth'
    ],

    'middleware_main' => 'check.domain.main',

    'middleware_tenant' => 'check.tenant',

    'prefix' => 'tenants'

];
