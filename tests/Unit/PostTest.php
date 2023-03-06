<?php

namespace Freziertz\PostPackage\Tests\Unit;


use Freziertz\PostPackage\Models\Post;
Use Freziertz\PostPackage\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Freziertz\PostPackage\Database\Factories\PostFactory;



class PostTest extends TestCase 
{

  use RefreshDatabase;


  /** @test */
  function a_post_has_a_title() 
  {

    $post = Post::factory()->create(['title' => 'Fake Title']);    
    $this->assertEquals('Fake Title', $post->title);
  }
}