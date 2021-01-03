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
        $password = env(Str::upper($tenant->db_name) . '_PASSWORD', $tenant->db_pass);

        config()->set('database.connections.tenant.host', $tenant->db_host);
        config()->set('database.connections.tenant.database', $tenant->db_name);
        config()->set('database.connections.tenant.username', $tenant->db_user);
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

    private function checkDomain()
    {
        return request()->getHost() === config('tenant.domain_main');
    }

    public function setDefaultConnection() : void
    {
        config()->set('database.default', 'mysql');

        DB::purge('mysql');

        DB::reconnect('mysql');
    }
}
