<?php

namespace Aristides\Multitenancy\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;

class InstallMultitenancyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multitenancy:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the package Multitenancy';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Laravel Breeze');

        (new Process(['composer', 'require', 'laravel/breeze', '--dev']))
            ->setTimeOut(null)
            ->disableOutput()
            ->run();

        (new Process(['php', 'artisan', 'breeze:install']))
            ->setTimeOut(null)
            ->disableOutput()
            ->run();

        $this->info('Installing Multitenancy');

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-config'
        ]);

        // Migrations
        if (! $this->migrationFileExists('create_tenants_table.php')) {
            copy(__DIR__.'/../../stubs/migrations/create_tenants_table.php', database_path('migrations/2021_01_10_000000_create_tenants_table.php'));
        }
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/tenants'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/migrations/tenants', database_path('migrations/tenants'));

        // Seeder
        copy(__DIR__.'/../../stubs/Seeder/DatabaseSeeder.php', database_path('seeders/DatabaseSeeder.php'));
        copy(__DIR__.'/../../stubs/Seeder/TenantSeeder.php', database_path('seeders/TenantSeeder.php'));
        copy(__DIR__.'/../../stubs/Seeder/UserSeeder.php', database_path('seeders/UserSeeder.php'));

        // Views
        copy(__DIR__.'/../../stubs/resources/views/dashboard.blade.php', base_path('resources/views/dashboard.blade.php'));
        (new Filesystem)->ensureDirectoryExists(base_path('resources/views/vendor/multitenancy/tenants'));
        copy(__DIR__.'/../../stubs/resources/views/tenants/index.blade.php', base_path('resources/views/vendor/multitenancy/tenants/index.blade.php'));

        // Routes
        copy(__DIR__.'/../../stubs/routes/tenant.php', base_path('routes/tenant.php'));

        // Controller
        (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Tenants'));
        copy(__DIR__.'/../../stubs/Http/Controllers/AppController.php', app_path('Http/Controllers/Tenants/AppController.php'));

        // Model
        (new Filesystem)->ensureDirectoryExists(app_path('Models/Tenants'));
        copy(__DIR__.'/../../stubs/Models/Tenants/Post.php', app_path('Models/Tenants/Post.php'));

        Artisan::call('migrate --seed');

        $this->info('Running "npm install && npm run dev" command to build your assets. Waiting...');

        (new Process(['npm', 'install']))
            ->setTimeOut(null)
            ->disableOutput()
            ->run();

        (new Process(['npm', 'run', 'dev']))
            ->setTimeOut(null)
            ->disableOutput()
            ->run();

        $this->info('Multitenancy installed successfully');
        $this->line('');

        $this->comment('Go to http://' . config('multitenancy.domain_main'));
        $this->comment('Email: admin@admin.com');
        $this->comment('Password: password');
    }

    public function migrationFileExists(string $migrationFileName): bool
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
