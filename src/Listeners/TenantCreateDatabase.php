<?php
declare(strict_types=1);

namespace Aristides\Multitenancy\Listeners;

use Illuminate\Support\Str;
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

        $password = env(Str::upper($tenant->database_name) . '_PASSWORD', $tenant->database_password);
        DB::statement("CREATE USER '{$tenant->database_user}'@'%' IDENTIFIED BY '{$password}'");

        DB::statement("GRANT ALL PRIVILEGES ON {$tenant->database_name}.* TO '{$tenant->database_user}'@'%'");

        DB::statement("FLUSH PRIVILEGES");

        Artisan::call("multitenancy:migrations {$tenant->id}");

        $tenant->migrated = true;
        $tenant->database_created = true;
        $tenant->save();
    }
}
