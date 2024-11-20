<?php

namespace DarioBarila\ComuniItaliani;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use DarioBarila\ComuniItaliani\Components\SelettoreRegione;
use DarioBarila\ComuniItaliani\Components\SelettoreProvincia;
use DarioBarila\ComuniItaliani\Components\SelettoreComune;

class ComuniItalianiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'comuni-italiani');

        // Register Livewire components
        Livewire::component('selettore-regione', SelettoreRegione::class);
        Livewire::component('selettore-provincia', SelettoreProvincia::class);
        Livewire::component('selettore-comune', SelettoreComune::class);

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ImportaComuniCommand::class,
            ]);

            // Publish migrations
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'comuni-italiani-migrations');

            // Publish config
            $this->publishes([
                __DIR__.'/../config/comuni-italiani.php' => config_path('comuni-italiani.php'),
            ], 'comuni-italiani-config');

            // Publish views
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/comuni-italiani'),
            ], 'comuni-italiani-views');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/comuni-italiani.php',
            'comuni-italiani'
        );
    }
}
