<?php

namespace Freziertz\PostPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Database\Factories\PostFactory;

class Post extends Model 
{

  use HasFactory;
  
  // Disable Laravel's mass assignment protection
  protected $guarded = [];


  protected static function newFactory()
  {
      return new PostFactory();
  }     

  
}