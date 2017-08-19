<?php

namespace Cmspapa\Core\Database\Seeds;

use Illuminate\Support\ServiceProvider;
use Cmspapa\Core\Database\Seeds\SeedCommand;

class SeedServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->singleton('command.seed', function ($app) {
            return new SeedCommand($app['db']);
        });

    }
}
