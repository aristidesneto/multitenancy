<?php

namespace Aristides\Multitenancy\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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

        $command = "composer require laravel/breeze --dev";
        $path = base_path();
        shell_exec("cd {$path} && {$command}");

        $this->info('Breeze scaffolding installed successfully.');

        $this->info('Installing multitenancy package');

        sleep(5);

        Artisan::call('breeze:install');

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-config'
        ]);

        // Migrations
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/tenants'));
        copy(__DIR__.'/../../stubs/migrations/create_tenants_table.php', database_path('migrations/' . date('Y_m_d_His', time()) . '_' . 'create_tenants_table.php'));
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

        // Docker compose
        copy(__DIR__.'/../../stubs/docker-compose.yml', base_path('docker-compose.yml'));

        Artisan::call('migrate --seed');

        $this->info('Multitenancy installed successfully');
        $this->comment('Running "npm install && npm run dev" command to build your assets.');

        shell_exec("cd {$path} && npm install && npm run dev");

        $this->comment('Successfully. Go to http://' . config('multitenancy.domain_main'));
    }
}
