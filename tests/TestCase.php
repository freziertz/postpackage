<?php

namespace Freziertz\PostPackage\Tests;

use Freziertz\PostPackage\PostServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase 
{
  

  public function setUp(): void 
  {

    parent::setUp();
    // additional setup
  }


  protected function getPackageProviders($app) 
  {
    
    return [
      PostServiceProvider::class,
    ];

  }


  protected function getEnvironmentSetUp($app) 
  {
      // perform environment setup

      // import the CreatePostsTable class from the migration
      include_once __DIR__ . '/../database/migrations/create_posts_table.php.stub';
      include_once __DIR__ . '/../database/migrations/create_users_table.php.stub';

      // run the up() method of that migration class
      (new \CreatePostsTable)->up();
      (new \CreateUsersTable)->up();

  }

}