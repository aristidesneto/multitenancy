<?php

namespace Aristides\Multitenancy\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Aristides\Multitenancy\Models\Tenant;
use Aristides\Multitenancy\Tenant\TenantManager;

class TenantMigrationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrations Tenants';

    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TenantManager $tenant)
    {
        parent::__construct();

        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($id = $this->argument('id')) {
            $tenant = Tenant::find($id);

            if ($tenant) {
                $this->execCommand($tenant);
            }

            return;
        }

        $companies = Tenant::all();

        foreach ($companies as $tenant) {
            $this->execCommand($tenant);
        }
    }

    private function execCommand(Tenant $tenant)
    {
        $command = 'migrate';

        $this->tenant->setConnection($tenant);

        $this->info("Connecting tenant {$tenant->name}");

        if ($this->option('fresh')) {
            $command = 'migrate:fresh';
        }

        $run = Artisan::call($command, [
            '--force' => true,
            '--path' => '/database/migrations/tenants',
        ]);

        $this->warn("Migration {$tenant->name} successfully");


        if ((!$tenant->migrated && $run === 0) || $this->option('seed')) {
            $this->execSeedCommand($tenant->name);
        }

        $this->info("End connecting tenant {$tenant->name}");
        $this->info('-----------------------------------------');
    }

    private function execSeedCommand(string $name)
    {
        Artisan::call('db:seed', [
            '--class' => 'TenantSeeder',
        ]);

        $this->warn("Seed {$name} successfully");
    }
}

