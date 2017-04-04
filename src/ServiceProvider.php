<?php

namespace Jaspaul\LaravelRollout;

use Opensoft\Rollout\Rollout;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Jaspaul\LaravelRollout\Console\ListCommand;
use Jaspaul\LaravelRollout\Console\CreateCommand;
use Jaspaul\LaravelRollout\Console\DeleteCommand;
use Jaspaul\LaravelRollout\Console\AddUserCommand;
use Jaspaul\LaravelRollout\Console\EveryoneCommand;
use Jaspaul\LaravelRollout\Console\DeactivateCommand;
use Jaspaul\LaravelRollout\Console\PercentageCommand;
use Jaspaul\LaravelRollout\Console\RemoveUserCommand;
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
            DeactivateCommand::class,
            DeleteCommand::class,
            EveryoneCommand::class,
            ListCommand::class,
            PercentageCommand::class,
            RemoveUserCommand::class
        ]);
    }
}
