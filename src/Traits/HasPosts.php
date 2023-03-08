<?php

namespace Freziertz\PostPackage\Traits;

use Freziertz\PostPackage\Models\Post;

trait HasPosts
{
  public function posts()
  {
    return $this->morphMany(Post::class, 'author');
  }
}
