<?php

namespace Aristides\Multitenancy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'name', 'domain', 'db_host', 'db_name', 'db_user', 'migrated', 'production'
    ];
}
