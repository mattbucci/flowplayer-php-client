<?php

namespace Flowplayer;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class FlowplayerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/flowplayer-php-client.php' => config_path('flowplayer-php-client.php'),
        ]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Flowplayer\Client', function($app)
        {
            $apiCaller = new APICaller(new HttpClient(), $app['config']['flowplayer-php-client']);
            return new Client($apiCaller);
        });
    }
}
