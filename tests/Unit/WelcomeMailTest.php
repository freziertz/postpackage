<?php

namespace Freziertz\PostPackage\Tests\Unit;

use Illuminate\Support\Facades\Mail;
use Freziertz\PostPackage\Mail\WelcomeMail;
use Freziertz\PostPackage\Models\Post;
use Freziertz\PostPackage\Tests\TestCase;

class WelcomeMailTest extends TestCase
{
    /** @test */
    public function it_sends_a_welcome_email()
    {
        

        Mail::fake();

        $post = Post::factory()->create(['title' => 'Fake Title']);

        Mail::assertNothingSent();

        Mail::to('test@example.com')->send(new WelcomeMail($post));

        Mail::assertSent(WelcomeMail::class, function ($mail) use ($post) {
            return $mail->post->id === $post->id
                && $mail->post->title === 'Fake Title';
        });
    }
}
