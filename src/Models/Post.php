<?php
declare(strict_types=1);

namespace Freziertz\PostPackage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Freziertz\PostPackage\Publishing\Enums\PostStatus;

use Database\Factories\PostFactory;

class Post extends Model 
{

  use HasFactory;

  // Disable Laravel's mass assignment protection
  // protected $guarded = [];

  protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'author_id',
        'author_type',
        'published_at',
  ];
 
  protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'datetime',
  ];


  protected static function newFactory()
  {
      return new PostFactory();
  }  


  // public function author()
  // {
  //   return $this->belongsTo(User::class);
  // } 


  public function author()
  {
    return $this->morphTo();
  }  

  
}