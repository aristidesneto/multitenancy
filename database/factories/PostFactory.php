<?php

namespace Aristides\Multitenancy\Database\Factories;

use Aristides\Multitenancy\Models\Tenants\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        return [
            'title'         => $this->faker->words(3, true),
            'description'   => $this->faker->paragraph
        ];
    }
}
