<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin Tenant',
            'email'     => 'admin@tenant.com',
            'password'  => bcrypt('password'),
        ]);
    }
}
