<?php
namespace Lattlay\LaravelCloner;

use Illuminate\Support\ServiceProvider;

class LaravelClonerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
    	if ($this->app->runningInConsole()) {
            $this->commands([
                Cloner::class
            ]);
        }
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }


}