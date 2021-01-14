<?php

namespace Aristides\Multitenancy\Tests\Unit;

use Aristides\Multitenancy\Tests\TestCase;
use Aristides\Multitenancy\Models\Tenants\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_post_has_a_title()
    {
        $post = Post::factory()->create([
            'title' => 'Meu titulo aqui',
            'description' => 'Descrição do post'
        ]);

        $this->assertEquals('Meu titulo aqui', $post->title);
        $this->assertEquals(1, Post::count());
    }
}
