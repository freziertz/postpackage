<?php

namespace Freziertz\PostPackage;

use Illuminate\Support\ServiceProvider;
use Freziertz\PostPackage\Console\InstallPostPackage;

class PostServiceProvider extends ServiceProvider 
{



    public function register() 
    {


      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'postpackage');


      $this->app->bind('calculator', function($app) {
          return new Calculator();
      });
      
    }



    public function boot() 
    {

      
      if ($this->app->runningInConsole()) {

        $this->publishes([
          __DIR__.'/../config/config.php' =>   config_path('postpackage.php'),
        ], 'config');


        $this->commands([
             InstallPostPackage::class,
         ]);


        if (! class_exists('CreatePostsTable')) {
          $this->publishes([
            __DIR__ . '/../database/migrations/create_posts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_posts_table.php'),
            // you can add any number of migrations here
          ], 'migrations');
        }

      }
    }

  
}