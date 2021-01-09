<?php

namespace Aristides\Multitenancy\Commands;

use Illuminate\Console\Command;
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

        Artisan::call('migrate --seed');

        Artisan::call('breeze:install');

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-config'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-migrations'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-seeder',
            '--force' => true
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-assets'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-views'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-routes'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-controller'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-model'
        ]);

        $this->info('Multitenancy installed successfully');

        $this->comment('Running "npm install && npm run dev" command to build your assets.');

        shell_exec("cd {$path} && npm install && npm run dev");
    }
}
