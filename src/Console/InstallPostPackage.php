<?php

namespace Freziertz\PostPackage\Console;


use Illuminate\Console\Command;


class InstallPostPackage extends Command 
{
    
    protected $signature = 'postpackage:install';


    protected $description = 'Install the PostPackage';


    public function handle() 
    {
        

        $this->info('Installing PostPackage...');

        
        $this->info('Publishing configuration...');

        
        $this->call('vendor:publish', [
            '--provider' => "Freziertz\PostPackage\PostServiceProvider",
            '--tag' => "config"
        ]);


        $this->info('Installed PostPackage');
    }
}