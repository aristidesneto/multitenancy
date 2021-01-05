<?php

namespace Aristides\Multitenancy\Events;

use Aristides\Multitenancy\Models\Tenant;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TenantCreate
{
    use Dispatchable, SerializesModels;

    private $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getTenant()
    {
        return $this->tenant;
    }
}
