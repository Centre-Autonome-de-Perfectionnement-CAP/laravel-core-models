<?php

namespace Cap\LaravelCoreModels;

use Illuminate\Support\ServiceProvider;

class LaravelCoreModelsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        $router->aliasMiddleware('error_handling', \Cap\LaravelCoreModels\Middlewares\ErrorHandling::class);
        $router->aliasMiddleware('verify_token', \Cap\LaravelCoreModels\Middlewares\VerifyToken::class);
        $router->pushMiddlewareToGroup('web', \Cap\LaravelCoreModels\Middlewares\ErrorHandling::class);
        $router->pushMiddlewareToGroup('api', \Cap\LaravelCoreModels\Middlewares\VerifyToken::class);
    }

    public function register()
    {
        //
    }
}
