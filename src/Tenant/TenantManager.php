<?php
declare(strict_types=1);

namespace Aristides\Multitenancy\Tenant;

use Aristides\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantManager
{
    public function setConnection(Tenant $tenant) : void
    {
        $password = env(Str::upper($tenant->database_name) . '_PASSWORD', $tenant->database_password);

        config()->set('database.connections.tenant.host', $tenant->database_host);
        config()->set('database.connections.tenant.database', $tenant->database_name);
        config()->set('database.connections.tenant.username', $tenant->database_user);
        config()->set('database.connections.tenant.password', $password);
        config()->set('database.default', 'tenant');

        DB::purge('tenant');

        DB::reconnect('tenant');
    }

    public function isDomainMain() : bool
    {
        return $this->checkDomain();
    }

    public function isTenant() : bool
    {
        return ! $this->checkDomain();
    }

    private function checkDomain() : bool
    {
        return request()->getHost() === config('multitenancy.base_domain');
    }

    public function setDefaultConnection() : void
    {
        config()->set('database.default', 'mysql');

        DB::purge('mysql');

        DB::reconnect('mysql');
    }
}
