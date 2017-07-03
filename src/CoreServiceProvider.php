<?php

namespace Cmspapa\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Symfony\Component\Yaml\Yaml;
use Composer\Autoload\ClassLoader;

class CoreServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         |--------------------------------------------------------------------------
         | Load modules from modules folder
         |--------------------------------------------------------------------------
         */
        $modules = array_filter(glob(base_path('modules').'/*'));

        foreach ($modules as $module) {
            
            if(file_exists($module.'/services.yml')){
                $yamlContents = Yaml::parse(file_get_contents($module.'/services.yml'));
            }

            /*
            |--------------------------------------------------------------------------
            | Migrations
            |--------------------------------------------------------------------------
            */

            $this->loadMigrationsFrom($module.'/src/database/migrations');
            
            /*
            |--------------------------------------------------------------------------
            |  Load modules routes
            |--------------------------------------------------------------------------
            */

            $moduleRoutesFiles = array_filter(glob(base_path('modules/'.basename($module).'/src/routes').'/*.php'));
            foreach ($moduleRoutesFiles as $moduleRoutesFile) {
                $this->loadRoutesFrom($moduleRoutesFile);
            }

            /*
            |--------------------------------------------------------------------------
            |  Load module views
            |--------------------------------------------------------------------------
            */

            $this->loadViewsFrom($module.'/src/views', basename($module));

        }



        // /*
        // |--------------------------------------------------------------------------
        // | Set Locale
        // |--------------------------------------------------------------------------
        // */
        // $locale = \Request::segment(1);
        // if( in_array($locale, array_column(config('cmspapa.locales'), 'code')) ){
        //     \App::setLocale($locale);
        // }

        // /*
        // |--------------------------------------------------------------------------
        // | Configration
        // |--------------------------------------------------------------------------
        // */

        // // Publish configration if we need to customize configration instead of default one. 
        // $this->publishes([
        //     __DIR__.'/config/cmspapa.php' => config_path('cmspapa.php'),
        // ], 'config');



        // /*
        // |--------------------------------------------------------------------------
        // | Views
        // |--------------------------------------------------------------------------
        // */

        // // The package views have not been published. Use the defaults.
        // $this->loadViewsFrom(__DIR__.'/views', 'Core');

        // // Publish views if we need to customize views instead of default one. 
        // $this->publishes([
        //     __DIR__.'/views' => base_path('resources/views/vendor/core'),
        // ], 'views');




        
        // |--------------------------------------------------------------------------
        // | Translations
        // |--------------------------------------------------------------------------
        

        // // Publish translations if we need to customize translations instead of default one. 
        // $this->publishes([
        //     __DIR__.'/Lang/' => resource_path('lang/vendor/core'),
        // ], 'lang');




        // /*
        // |--------------------------------------------------------------------------
        // | Public assets
        // |--------------------------------------------------------------------------
        // */
        // $this->publishes([
        //     __DIR__.'/Public' => public_path('vendor/core'),
        // ], 'public');


        // /*
        // |--------------------------------------------------------------------------
        // | Core Global sharing
        // |--------------------------------------------------------------------------
        // |
        // | 1- Load lang
        // | 2- AdminMenu
        // */

        // $packagesDir = realpath(__DIR__.'/../..');
        // $modules = scandir($packagesDir);
        // $langPath = [];
        // foreach ($modules as $module) {
        //     // Load Lang
        //     $langPath = $packagesDir.'/'.$module.'/src/lang';
        //     if(file_exists($langPath)){
        //         $this->loadTranslationsFrom($packagesDir.'/'.$module.'/src/lang', ucwords($module));
        //     }
        //     // Admin menu
        //     $adminMenuFilePath = $packagesDir.'/'.$module.'/src/menus/admin_menu.php';
        //     if(file_exists($adminMenuFilePath)){
        //         include $adminMenuFilePath;
        //     }
        // }
        // ksort($adminMenu);
        // View::share('adminMenu', $adminMenu);

        // /*
        // |--------------------------------------------------------------------------
        // | Demo languages
        // |--------------------------------------------------------------------------
        // */
        // $languages = config('cmspapa.locales');
        // View::share('languages', $languages);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // /*
        // |--------------------------------------------------------------------------
        // | Configration The package configration have not been published. Use the defaults.
        // |--------------------------------------------------------------------------
        // */
        // $this->mergeConfigFrom(
        //     __DIR__.'/config/core.php', 'core'
        // );

        // $this->mergeConfigFrom(
        //     __DIR__.'/config/cmspapa.php', 'cmspapa'
        // );


        // load class by composer psr4
        $loader = require base_path() . '/vendor/autoload.php';

        // CMSPAPA DEVELOPMENT 
        // PSR4 core controllers in cms papa development env
        if (file_exists(base_path('packages/cmspapa/core/src/Controllers'))){
            $loader->setPsr4('Cmspapa\\Core\\Controllers\\', base_path('packages/cmspapa/core/src/Controllers'));
        }
        
        $modules = array_filter(glob(base_path('modules').'/*'));

        foreach ($modules as $module) {
            // PSR4 modules controllers
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Controllers\\', base_path('modules').'/'.basename($module).'/src/Controllers');

            // PSR4 modules models
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Models\\', base_path('modules').'/'.basename($module).'/src/Models');

            // PSR4 providers
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Providers\\', base_path('modules').'/'.basename($module).'/src/Providers');

            // Auto load all service providers for module
            $moduleProviders = array_filter(glob(base_path('modules/'.basename($module).'/src/Providers').'/*'));
            foreach ($moduleProviders as $moduleProvider) {
                $providerClass = 'Cmspapa\\'.basename($module).'\\Providers\\'.basename($moduleProvider, '.php');
                $this->app->register($providerClass);
            }
            
        }

       
    }

}
