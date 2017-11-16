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
        $this->app->make('Selfreliance\Adminrole\AdminRoleController');
        $this->loadViewsFrom(__DIR__.'/views', 'adminrole');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'translate-roles');
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
