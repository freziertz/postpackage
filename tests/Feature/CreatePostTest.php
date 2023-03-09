<?php

namespace Freziertz\PostPackage\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Freziertz\PostPackage\Models\Post;
use Freziertz\PostPackage\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Freziertz\PostPackage\Events\PostWasCreated;
use Freziertz\PostPackage\Listeners\UpdatePostTitle;
use Freziertz\PostPackage\Tests\User;
use Illuminate\Support\Str;
use Freziertz\PostPackage\Http\Middleware\CapitalizeTitle;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;



    /** @test */
    function authenticated_users_can_create_a_post()
    {

        $this->withoutExceptionHandling();
        // To make sure we don't start with a Post

        Event::fake();

    
        $this->assertCount(0, Post::all());

        $author = User::factory()->create();

        $title ='My first fake title';
        $slug =  Str::slug($title);


        $response = $this->actingAs($author)->post(route('posts.store'), [
            'title' => $title,
            'content'  => 'My first fake content',
            'slug' => $slug,
        ]);

        $this->assertCount(1, Post::all());

        tap(Post::first(), function ($post) use ($response, $author) {
            $this->assertEquals('My first fake title', $post->title);
            $this->assertEquals('My first fake content', $post->content);
            $this->assertTrue($post->author->is($author));
            $response->assertRedirect(route('posts.show', $post));
        });
    }


    /** @test */
    // function a_post_requires_a_title_and_a_content()
    // {

    //     $this->withoutExceptionHandling();

    //     $author = User::factory()->create();

    //     $title = 'My first fake title';
    //     $slug =  Str::slug($title);

    //     $this->actingAs($author)->post(route('posts.store'), [
    //         'title' => 'a',
    //         'content'  => 'Some valid content',
    //         'slug' => $slug,
    //     ])->assertSessionHasErrors('title');

    //     $this->actingAs($author)->post(route('posts.store'), [
    //         'title' => 'Some valid title',
    //         'content'  => 'b',
    //         'slug' => $slug,
    //     ])->assertSessionHasErrors('content');
    // }


    /** @test */
    function guests_can_not_create_posts()
    {

        // We're starting from an unauthenticated state
        $this->assertFalse(auth()->check());

        $this->post(route('posts.store'), [
           'title' => 'A valid title',
           'content'  => 'A valid content',
        ])->assertForbidden();
    }


    /** @test */
    function all_posts_are_shown_via_the_index_route()
    {

        $this->withoutExceptionHandling();
        // Given we have a couple of Posts
        Post::factory()->create([
            'title' => 'Post number 1'
        ]);
        Post::factory()->create([
            'title' => 'Post number 2'
        ]);
        Post::factory()->create([
            'title' => 'Post number 3'
        ]);

        // We expect them to all show up
        // with their title on the index route
        $this->get(route('posts.index'))
            ->assertSee('Post number 1')
            ->assertSee('Post number 2')
            ->assertSee('Post number 3')
            ->assertDontSee('Post number 4');
    }

    /** @test */
    function a_single_post_is_shown_via_the_show_route()
    {

        $this->withoutExceptionHandling();

        $post = Post::factory()->create([
            'title' => 'The single post title',
            'content'  => 'The single post content',
        ]);

        $this->get(route('posts.show', $post))
            ->assertSee('The single post title');
            // ->assertSee('The single post content');
    }


      /** @test */
      function an_event_is_emitted_when_a_new_post_is_created()
      {
          Event::fake();

          $author = User::factory()->create();

          $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'A valid title',
            'content' => 'A valid content',
          ]);

          $post = Post::first();

          Event::assertDispatched(PostWasCreated::class, function ($event) use ($post) {
              return $event->post->id === $post->id;
          });
      }


          /** @test */
    function a_newly_created_posts_title_will_be_changed()
    {
        $post = Post::factory()->create([
            'title' => 'Initial title',
        ]);

        $this->assertEquals('Initial title', $post->title);

        (new UpdatePostTitle())->handle(
            new PostWasCreated($post)
        );

        $this->assertEquals('New: ' . 'Initial title', $post->fresh()->title);
    }


        /** @test */
    function the_title_of_a_post_is_updated_whenever_a_post_is_created()
    {
         $author = User::factory()->create();

        $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'A valid title',
            'content' => 'A valid content',
        ]);

        $post = Post::first();

       $this->assertEquals('New: ' . 'A valid title', $post->title);
    }


        /** @test */
    function creating_a_post_will_capitalize_the_title()
    {
        $author = User::factory()->create();

        $this->actingAs($author)->post(route('posts.store'), [
            'title' => 'some title that was not capitalized',
            'content' => 'A valid content',
        ]);

        $post = Post::first();

        // 'New: ' was added by our event listener
        $this->assertEquals('New: Some title that was not capitalized', $post->title);
    }
}
