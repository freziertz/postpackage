<?php

namespace Database\Factories;

use Freziertz\PostPackage\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Freziertz\PostPackage\Publishing\Enums\PostStatus;
use Freziertz\PostPackage\Tests\User;



class PostFactory extends Factory
{

    protected $model = Post::class;
 
    public function definition(): array
    {  

        $title = $this->faker->sentence();
        $status = Arr::random(PostStatus::cases());  
        $author = User::factory()->create();      
 
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(),
            // 'author_id' => 999,
            'status' => $status->value,
            'author_id' => $author->id,
            'author_type' => get_class($author),
            'published_at' => $status === PostStatus::PUBLISHED
                ? now()
                : null,     
        ];
    }
}


