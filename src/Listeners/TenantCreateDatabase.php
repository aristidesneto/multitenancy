<?php
declare(strict_types=1);

namespace Aristides\Multitenancy\Listeners;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Aristides\Multitenancy\Events\TenantCreate;

class TenantCreateDatabase
{
    public function handle(TenantCreate $event) : void
    {
        $tenant = $event->getTenant();

        DB::statement("
            CREATE DATABASE IF NOT EXISTS {$tenant->database_name}
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci"
        );

        Artisan::call("multitenancy:migrations {$tenant->id}");

        $tenant->migrated = true;
        $tenant->database_created = true;
        $tenant->save();
    }
}
