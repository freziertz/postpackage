<?php

namespace Freziertz\PostPackage\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
Use Freziertz\PostPackage\Tests\TestCase;

class InstallPostPackageTest extends TestCase 
{
    
    /** @test */
    function the_install_command_copies_a_the_configuration() 
    {
        // make sure we're starting from a clean state
        if (File::exists(config_path('postpackage.php'))) {
            unlink(config_path('postpackage.php'));
        }

        $this->assertFalse(File::exists(config_path('postpackage.php')));

        Artisan::call('postpackage:install');

        $this->assertTrue(File::exists(config_path('postpackage.php')));
    }
}