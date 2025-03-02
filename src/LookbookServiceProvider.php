<?php

namespace LaravelLookbook;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use LaravelLookbook\Commands;

class LookbookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lookbook');
        // Register view composer
        View::composer('lookbook::components.navigation', \LaravelLookbook\View\Composers\NavigationViewComposer::class);


        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/lookbook.php' => config_path('lookbook.php'),
        ], 'lookbook-config');

        // Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/lookbook'),
        ], 'lookbook-views');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallLookbookCommand::class,
                Commands\MakeLookbookComponentCommand::class,
            ]);
        }
    }

    public function register()
    {
        // Register the Lookbook facade
        $this->app->singleton('lookbook', function ($app) {
            return new Lookbook();
        });

        // Merge configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/lookbook.php',
            'lookbook'
        );
    }
}
