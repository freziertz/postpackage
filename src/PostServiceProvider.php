<?php

namespace Freziertz\PostPackage;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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


      $this->registerRoutes();

      
      if ($this->app->runningInConsole()) {

        $this->publishes([
          __DIR__.'/../resources/views' => resource_path('views/vendor/postpackage'),
        ], 'views');


        $this->publishes([
          __DIR__.'/../config/config.php' =>   config_path('postpackage.php'),
        ], 'config');



          // Publish assets
        $this->publishes([
          __DIR__.'/../resources/assets' => public_path('postpackage'),
        ], 'assets');


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



      $this->loadViewsFrom(__DIR__.'/../resources/views', 'postpackage');



      // $this->loadRoutesFrom(__DIR__.'/../routes/web.php');





    


    }


    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('postpackage.prefix'),
            'middleware' => config('postpackage.middleware'),
        ];
    }

  
}