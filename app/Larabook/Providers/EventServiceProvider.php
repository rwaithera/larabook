<?php  namespace Larabook\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider{

    /**
     * Register Larabook Event Listeners
     */
    public function register(){

        $this->app['events']->listen('Larabook.*', 'Larabook\Handlers\EmailNotifier');
    }

}