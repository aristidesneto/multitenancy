<?php

namespace Aristides\Multitenancy\Database\Factories;

use Illuminate\Support\Str;
use Aristides\Multitenancy\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        $subdomain = ['client1', 'client2', 'client3', 'client4', 'client5'];

        return [
            'uuid' => $this->faker->uuid,
            'name' => $this->faker->name,
            'subdomain' => $this->faker->domainName,
            'database_name' => $this->faker->word(1, true),
            'database_host' => $this->faker->domainWord,
            'database_user' => $this->faker->userName,
            'database_password' => $this->faker->password(6, 8),
            'migrated' => false,
            'database_created' => false,
            'production' => false,
            'production_at' => null
        ];
    }
}
