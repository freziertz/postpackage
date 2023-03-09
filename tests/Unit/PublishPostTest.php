<?php

namespace Freziertz\PostPackage\Tests\Unit;

use Illuminate\Support\Facades\Bus;
use Freziertz\PostPackage\Jobs\PublishPost;
use Freziertz\PostPackage\Models\Post;
use Freziertz\PostPackage\Tests\TestCase;

class PublishPostTest extends TestCase
{
    /** @test */
    public function it_publishes_a_post()
    {
        Bus::fake();

        $post = Post::factory()->create();

        $this->assertNull($post->published_at);

        PublishPost::dispatch($post);

        Bus::assertDispatched(PublishPost::class, function ($job) use ($post) {
            return $job->post->id === $post->id;
        });
    }
}
