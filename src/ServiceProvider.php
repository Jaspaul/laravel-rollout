<?php

namespace Jaspaul\LaravelRollout;

use Opensoft\Rollout\Rollout;
use Illuminate\Cache\Repository;
use Illuminate\Cache\DatabaseStore;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Contracts\Encryption\Encrypter;
use Jaspaul\LaravelRollout\Console\ListCommand;
use Jaspaul\LaravelRollout\Console\CreateCommand;
use Jaspaul\LaravelRollout\Console\DeleteCommand;
use Jaspaul\LaravelRollout\Console\AddUserCommand;
use Jaspaul\LaravelRollout\Console\AddGroupCommand;
use Jaspaul\LaravelRollout\Console\EveryoneCommand;
use Illuminate\Contracts\Config\Repository as Config;
use Jaspaul\LaravelRollout\Console\DeactivateCommand;
use Jaspaul\LaravelRollout\Console\PercentageCommand;
use Jaspaul\LaravelRollout\Console\RemoveUserCommand;
use Jaspaul\LaravelRollout\Console\RemoveGroupCommand;
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
        $this->publishConfigurations();

        $this->loadMigrations();

        $this->app->singleton(Rollout::class, function ($app) {
            $config = $app->make(Config::class);

            if ($config->get('laravel-rollout.storage') === 'database') {
                $table = $config->get('laravel-rollout.table');

                $repository = new Repository($app->makeWith(DatabaseStore::class, ['table' => $table]));
                $driver = new Cache($repository);
            } else {
                $driver = new Cache($app->make('cache.store'));
            }

            $this->loadGroups($rollout = new Rollout($driver), $config->get('laravel-rollout.groups'));

            return $rollout;
        });

        $this->commands([
            AddGroupCommand::class,
            AddUserCommand::class,
            CreateCommand::class,
            DeactivateCommand::class,
            DeleteCommand::class,
            EveryoneCommand::class,
            ListCommand::class,
            PercentageCommand::class,
            RemoveGroupCommand::class,
            RemoveUserCommand::class
        ]);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../resources/config/laravel-rollout.php',
            'laravel-rollout'
        );
    }

    /**
     * Adds our configuration file to the publishes array.
     *
     * @return void
     */
    protected function publishConfigurations()
    {
        $this->publishes([
            __DIR__.'/../resources/config/laravel-rollout.php' => config_path('laravel-rollout.php'),
        ]);
    }

    /**
     * Loads our migrations.
     *
     * @return void
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../resources/migrations');
    }

    /**
     * Loads our groups
     *
     * @return void
     */
    protected function loadGroups(Rollout $rollout, array $groups)
    {
        foreach ($groups as $group) {
            $instance = resolve($group);
            $rollout->defineGroup($instance->getName(), function ($user = null) use ($instance) {
                return $instance->hasMember($user);
            });
        }
    }
}
