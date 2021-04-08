<?php

namespace Tofaha\Helper\Services;

use Illuminate\Support\ServiceProvider;
use Tofaha\Helper\Console\InstallHelperPackage;
use Tofaha\Helper\Console\NewForm;
use Tofaha\Helper\Console\NewModel;
use Tofaha\Helper\Helper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'helper');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'helper');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('helper.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../../resources/views/tofaha' => resource_path('views/vendor/tofaha'),
            ], 'views');

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/helper'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/helper'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                InstallHelperPackage::class,
                NewForm::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'helper');

        // Register the main class to use with the facade
        $this->app->singleton('helper', function () {
            return new Helper();
        });
    }
}
