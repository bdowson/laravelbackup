<?php
namespace Lattlay\LaravelBackup;

use Illuminate\Support\ServiceProvider;
use Lattlay\LaravelBackup\Commands\BackupCommand;
use Lattlay\LaravelBackup\Commands\RestoreCommand;

class LaravelBackupServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
    	if ($this->app->runningInConsole()) {
            $this->commands([
                BackupCommand::class,
                RestoreCommand::class
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