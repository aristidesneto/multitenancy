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
            $table->string('name');
            $table->string('domain')->unique();
            $table->string('db_name')->unique();
            $table->string('db_host');
            $table->string('db_user');
            $table->string('db_pass')->nullable();
            $table->boolean('migrated')->default(0);
            $table->boolean('production')->default(0);
            $table->datetime('production_at')->nullable();
            $table->timestamps();
        });
    }
}