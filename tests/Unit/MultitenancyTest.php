<?php

namespace Aristides\Multitenancy\Tests\Unit;

use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;
use Aristides\Multitenancy\Tests\TestCase;

class MultitenancyTest extends TestCase
{
    /** @test */
    public function seeder_tenants()
    {
        $subdomain = ['client1', 'client2', 'client3', 'client4', 'client5'];

        foreach ($subdomain as $item) {
            Tenant::factory()->create([
                'subdomain' => $item,
                'database_name' => 'db_' . $item
            ]);
        }

        $tenant = Tenant::find(random_int(1,5));

        // test new tenant connection
        $manager = new TenantManager();
        $manager->setConnection($tenant);

        dd(config('database.connections.tenant.host'));

        // $this->assertDatabaseHas('tenants', );
    }
}
