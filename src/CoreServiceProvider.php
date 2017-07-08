<?php

namespace Cmspapa\Core;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

use Symfony\Component\Yaml\Yaml;
use Composer\Autoload\ClassLoader;

use Illuminate\Filesystem\Filesystem;

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
         | Load themes from themes folder
         |--------------------------------------------------------------------------
         */
        $coreThemes = array_filter(glob(__DIR__.'/themes/*'));
        $appThemes = array_filter(glob(base_path('themes').'/*'));
        $themes = array_merge($coreThemes, $appThemes);

        // File system
        $fs = new Filesystem();

        // Loop through themes.
        foreach ($themes as $theme) {
            
            /*
            |--------------------------------------------------------------------------
            |  Link theme assets
            |--------------------------------------------------------------------------
            */
            if(file_exists($theme.'/assets') && !file_exists(base_path('public/themes_'.basename($theme).'_assets'))){
                $fs->link($theme.'/assets', base_path('public/themes_'.basename($theme).'_assets'));
            }

            /*
            |--------------------------------------------------------------------------
            |  Load theme views
            |--------------------------------------------------------------------------
            */

            $this->loadViewsFrom($theme, basename($theme));
            
        }

        /*
         |--------------------------------------------------------------------------
         | Load modules from modules folder
         |--------------------------------------------------------------------------
         */

        $coreModules = array_filter(glob(__DIR__.'/modules/*'));
        $appModules = array_filter(glob(base_path('modules').'/*'));
        $modules = array_merge($coreModules, $appModules);

        foreach ($modules as $module) {
            
            if(file_exists($module.'/src/admin_menu.yml')){
                $adminMenu = Yaml::parse(file_get_contents($module.'/src/admin_menu.yml'));
                // dd($adminMenu);
                View::share('adminMenu', $adminMenu);
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

            $moduleRoutesFiles = array_filter(glob($module.'/src/routes/*.php'));
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

        // Load core modules
        if(is_dir(base_path('packages/cmspapa/core/src/modules'))){
            $coreModules = array_filter(glob(base_path('packages/cmspapa/core/src/modules').'/*'));
            $this->loadModulesPsr4($loader, $coreModules, base_path('packages/cmspapa/core/src/modules'));
        }else{
            $coreModules = array_filter(glob(base_path('vendor/cmspapa/core/src/modules').'/*'));
            $this->loadModulesPsr4($loader, $coreModules, base_path('vendor/cmspapa/core/src/modules'));
        }
        
        // Load app modules
        $appModules = array_filter(glob(base_path('modules').'/*'));
        $this->loadModulesPsr4($loader, $appModules, base_path('modules'));

    }

    /**
     * Load modules psr4.
     *
     * @return void
     */
    public function loadModulesPsr4($loader, $modules, $modulesFolderPath)
    {
        foreach ($modules as $module) {
            // PSR4 modules controllers
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Controllers\\', $module.'/src/Controllers');

            // PSR4 modules models
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Models\\', $module.'/src/Models');

            // PSR4 providers
            $loader->setPsr4('Cmspapa\\'.basename($module).'\\Providers\\', $module.'/src/Providers');

            // Auto load all service providers for module
            $moduleProviders = array_filter(glob($module.'/src/Providers/*'));
            foreach ($moduleProviders as $moduleProvider) {
                $providerClass = 'Cmspapa\\'.basename($module).'\\Providers\\'.basename($moduleProvider, '.php');
                $this->app->register($providerClass);
            }
        }
    }

}
