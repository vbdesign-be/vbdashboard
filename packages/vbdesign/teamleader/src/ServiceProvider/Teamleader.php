<?php

namespace Vbdesign\Teamleader\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class Teamleader extends ServiceProvider
{
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/teamleader.php' => config_path('teamleader.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('teamleader', function ($app) {
            $config = $app->make('config')->get('teamleader');

            return new \Vbdesign\Teamleader\Teamleader($config['api_url'], $config['auth_url'], $config['client_id'], $config['client_secret'], $config['redirect_uri'], $config['client']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['teamleader'];
    }
}
