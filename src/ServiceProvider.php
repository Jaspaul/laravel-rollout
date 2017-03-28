<?php

namespace Jaspaul\LaravelRollout;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/rollout.php' => $this->app->make('path.config') . DIRECTORY_SEPARATOR . 'rollout.php'
            ]);
        }
    }
}
