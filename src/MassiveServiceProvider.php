<?php

namespace Pjmarshall1\Massive;

use Illuminate\Support\ServiceProvider;

class MassiveServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/massive.php', 'massive');

        $this->app->singleton(Massive::class, fn (): Massive => new Massive(
            apiKey: config('massive.api_key'),
            baseUrl: config('massive.base_url'),
            streamUrl: config('massive.stream_url'),
            delayedStreamUrl: config('massive.delayed_stream_url'),
            businessStreamUrl: config('massive.business_stream_url'),
            timeout: config('massive.timeout'),
            connectTimeout: config('massive.connect_timeout'),
            retryDelays: config('massive.retry_delays'),
        ));

        $this->app->alias(Massive::class, 'massive');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/massive.php' => config_path('massive.php'),
        ], 'massive-config');
    }
}
