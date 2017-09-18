<?php

namespace Selfreliance\adminrole;

use Illuminate\Support\ServiceProvider;

class AdminRoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        include __DIR__.'/routes.php';
        $this->app->make('Selfreliance\adminrole\AdminRoleController');
        $this->loadViewsFrom(__DIR__.'/views', 'adminrole');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
