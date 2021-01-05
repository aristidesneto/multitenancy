<?php

return [

    'domain_main' => 'master.tenancy.test',

    'middleware' => [
        'web',
        'auth',
        'check.domain.main'
    ],

    'prefix' => 'tenants'

];
