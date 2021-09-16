<?php

namespace HenryEjemuta\LaravelHusmoData;

use HenryEjemuta\LaravelHusmoData\Console\InstallLaravelHusmoData;
use Illuminate\Support\ServiceProvider;

class HusmoDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('husmodata.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                InstallLaravelHusmoData::class,
            ]);

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'husmodata');

        // Register the main class to use with the facade
        $this->app->singleton('husmodata', function ($app) {
            $baseUrl = config('husmodata.base_url');
            $instanceName = 'husmodata';

            return new HusmoData(
                $baseUrl,
                $instanceName,
                config('husmodata')
            );
        });

    }
}
