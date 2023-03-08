<?php

namespace Freziertz\PostPackage\Tests\Unit;


use Freziertz\PostPackage\Models\Post;
Use Freziertz\PostPackage\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Freziertz\PostPackage\Tests\User;
use Freziertz\PostPackage\Publishing\Enums\PostStatus;
use Illuminate\Support\Arr;
// use Freziertz\PostPackage\Database\Factories\PostFactory;



class PostTest extends TestCase 
{

  use RefreshDatabase;


  /** @test */
  function a_post_has_a_title() 
  {

    $post = Post::factory()->create(['title' => 'Fake Title']);    
    $this->assertEquals('Fake Title', $post->title);
  }


    /** @test */
  function a_post_has_a_content()
  {
    $post = Post::factory()->create(['content' => 'Fake content']);
    $this->assertEquals('Fake content', $post->content);
  }


    /** @test */
  function a_post_has_an_author_id()
  {
    // Note that we are not assuming relations here, just that we have a column to store the 'id' of the author
    // $post = Post::factory()->create(['author_id' => 999]); // we choose an off-limits value for the author_id so it is unlikely to collide with another author_id in our tests
    // $this->assertEquals(999, $post->author_id);


    $post = Post::factory()->create(['author_type' => 'Fake\User']);
    $this->assertEquals('Fake\User', $post->author_type);
  }

      /** @test */
  function a_post_has_a_slug()
  {
    $title = "Fake title";
    $slug =  Str::slug($title);
    $post = Post::factory()->create(['slug' => $slug ]);
    $this->assertEquals('fake-title', $post->slug);
  }



  /** @test */
  function a_post_belongs_to_an_author()
  {
    // Given we have an author
    $author = User::factory()->create();
    // And this author has a Post

    $title = "My first fake post";
    $slug =  Str::slug($title);
    $status = Arr::random(PostStatus::cases());  

    $author->posts()->create([
        'title' => 'My first fake post',
        'content'  => 'The content of this fake post',
         'slug'      => Str::slug($title),
         'status'      => $status->value,
         'published_at' => $status === PostStatus::PUBLISHED ? now() : null,
        
    ]);

    $this->assertCount(1, Post::all());
    $this->assertCount(1, $author->posts);

    // Using tap() to alias $author->posts()->first() to $post
    // To provide cleaner and grouped assertions
    tap($author->posts()->first(), function ($post) use ($author) {
        $this->assertEquals('My first fake post', $post->title);
        $this->assertEquals('The content of this fake post', $post->content);
        $this->assertTrue($post->author->is($author));
    });

  }


}