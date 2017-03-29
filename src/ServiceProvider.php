<?php

namespace Jaspaul\LaravelRollout;

use Opensoft\Rollout\Rollout;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Jaspaul\LaravelRollout\Console\ListCommand;
use Jaspaul\LaravelRollout\Console\CreateCommand;
use Jaspaul\LaravelRollout\Console\AddUserCommand;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Rollout::class, function ($app) {
            return new Rollout(new Cache($app->make('cache.store')));
        });

        $this->commands([
            AddUserCommand::class,
            CreateCommand::class,
            ListCommand::class
        ]);
    }
}
