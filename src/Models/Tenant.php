<?php

namespace Aristides\Multitenancy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'subdomain',
        'database_host',
        'database_name',
        'database_user',
        'database_password',
        'migrated',
        'database_created',
        'production_at',
        'production'
    ];

    protected $dates = [
        'production_at'
    ];
}
