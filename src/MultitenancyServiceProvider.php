<?php

namespace Aristides\Multitenancy;

use Aristides\Multitenancy\Commands\TenantMigrationsCommand;
use Illuminate\Support\ServiceProvider;

class MultitenancyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/multitenancy.php' => config_path('multitenancy.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/vendor/multitenancy'),
            ], 'views');

            $migrationFileName = 'create_tenants_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }

            $this->commands([
                TenantMigrationsCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__. '/routes/master.php');
        $this->loadRoutesFrom(__DIR__. '/routes/auth.php');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'multitenancy');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/multitenancy.php', 'multitenancy');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
