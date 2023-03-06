<?php

namespace Database\Factories;

use Freziertz\PostPackage\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;



class PostFactory extends Factory
{
    protected $model = Post::class;
 
    public function definition(): array
    {
        $title = $this->faker->sentence();
      
 
        return [
            // 'title' => $title,            
        ];
    }
}


// $factory->define(Post::class, function (Faker $faker) {
//   return [
//     //
//   ];
// });