<?php

namespace Guimcaballero\LaravelFolders;

use Illuminate\Support\ServiceProvider;

class LaravelFoldersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-folders');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-folders');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-folders.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '../database/migrations/2020_04_20_141823_create_folders_table.php' => database_path('migrations/'.date('Y-m-d-His').'_create_folders_table.php'),
            ], 'config');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-folders');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-folders', function () {
            return new LaravelFolders;
        });
    }
}
