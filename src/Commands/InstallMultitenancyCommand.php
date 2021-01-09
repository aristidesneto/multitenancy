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
        Artisan::call('breeze:install');

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-config'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-migrations'
        ]);

        Artisan::call('vendor:publish', [
            '--tag' =>  'multitenancy-seeder'
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
    }
}
