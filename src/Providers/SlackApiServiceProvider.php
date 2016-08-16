<?php

namespace Lisennk\Laravel\SlackWebApi\Providers;

use Illuminate\Support\ServiceProvider;
use Lisennk\Laravel\SlackWebApi\SlackApi;

class SlackApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(dirname(__FILE__)).'/config/slack.php' => config_path('slack.php'),
        ]);
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SlackApi::class, function ($app) {
            return new SlackApi(config('slack.token'));
        });
    }
}