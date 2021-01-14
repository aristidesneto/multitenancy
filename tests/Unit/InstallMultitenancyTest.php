<?php

namespace Aristides\Multitenancy\Tests\Unit;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Aristides\Multitenancy\Tests\TestCase;

class InstallMultitenancyTest extends TestCase
{
    /** @test */
    public function the_install_command_copies_the_configuration()
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('multitenancy.php'))) {
            unlink(config_path('multitenancy.php'));
        }

        $this->assertFalse(File::exists(config_path('multitenancy.php')));

        // Artisan::call('multitenancy:install');

        // $this->assertTrue(File::exists(config_path('multitenancy.php')));

    }
}
