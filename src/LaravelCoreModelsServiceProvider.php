<?php

namespace Cap\LaravelCoreModels;

use Illuminate\Support\ServiceProvider;

class LaravelCoreModelsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
    }

    public function register()
    {
        //
    }
}
