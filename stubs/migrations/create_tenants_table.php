<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->comment('Tenant name');
            $table->string('subdomain')->unique()->comment('Tenant subdomain');
            $table->string('database_name')->unique()->comment('Tenant database name');
            $table->string('database_host')->comment('Tenant hostname');
            $table->string('database_user')->comment('Tenant user name');
            $table->string('database_password')->nullable()->comment('Tenant password');
            $table->boolean('migrated')->default(0)->comment('If the migration was successful');
            $table->boolean('database_created')->default(0)->comment('If the database was created successful');
            $table->boolean('production')->default(0)->comment('If the application is on production');
            $table->datetime('production_at')->nullable();
            $table->timestamps();
        });
    }
}
