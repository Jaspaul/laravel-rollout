<?php

namespace Tests;

use Mockery;
use Opensoft\Rollout\Rollout;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository;
use Jaspaul\LaravelRollout\ServiceProvider;
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
use Tests\Doubles\SampleGroup;

class ServiceProviderTest extends TestCase
{
    private $container;
    private $serviceProvider;

    /**
     * @before
     */
    public function setup_service_provider()
    {
        $this->container = Container::getInstance();
        $this->serviceProvider = new ServiceProvider($this->container);
    }

    /**
     * @test
     */
    public function ensure_a_service_provider_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->serviceProvider);
        $this->assertInstanceOf(IlluminateServiceProvider::class, $this->serviceProvider);
    }

    /**
     * @test
     */
    public function booting_registers_a_cache_backed_rollout_singleton_into_the_container()
    {
        $this->container->singleton(Config::class, function ($app) {
            $config = Mockery::mock(Config::class);
            $config->shouldReceive('get')
                ->with('laravel-rollout.storage')
                ->andReturn('cache');
            $config->shouldReceive('get')
                ->with('laravel-rollout.groups')
                ->andReturn([]);

            return $config;
        });

        $this->container->singleton('cache.store', function ($app) {
            return Mockery::mock(Repository::class);
        });

        $this->serviceProvider->boot();

        $result = $this->container->make(Rollout::class);
        $this->assertInstanceOf(Rollout::class, $result);
    }

    /**
     * @test
     */
    public function booting_registers_a_database_backed_rollout_singleton_into_the_container()
    {
        $this->container->singleton(Config::class, function ($app) {
            $config = Mockery::mock(Config::class);
            $config->shouldReceive('get')
                ->with('laravel-rollout.storage')
                ->andReturn('database');

            $config->shouldReceive('get')
                ->with('laravel-rollout.table')
                ->andReturn('rollout');

            $config->shouldReceive('get')
                ->with('laravel-rollout.groups')
                ->andReturn([]);

            return $config;
        });

        $this->container->singleton(ConnectionInterface::class, function ($app) {
            return Mockery::mock(ConnectionInterface::class);
        });

        $this->container->singleton(Encrypter::class, function ($app) {
            return Mockery::mock(Encrypter::class);
        });

        $this->serviceProvider->boot();

        $result = $this->container->make(Rollout::class);
        $this->assertInstanceOf(Rollout::class, $result);
    }

    /**
     * @test
     */
    public function booting_registers_the_groups_into_rollout()
    {
        $this->container->singleton(Config::class, function ($app) {
            $config = Mockery::mock(Config::class);
            $config->shouldReceive('get')
                ->with('laravel-rollout.storage')
                ->andReturn('database');

            $config->shouldReceive('get')
                ->with('laravel-rollout.table')
                ->andReturn('rollout');

            $config->shouldReceive('get')
                ->with('laravel-rollout.groups')
                ->andReturn([
                    SampleGroup::class
                ]);

            return $config;
        });

        $this->container->singleton(ConnectionInterface::class, function ($app) {
            return Mockery::mock(ConnectionInterface::class);
        });

        $this->container->singleton(Encrypter::class, function ($app) {
            return Mockery::mock(Encrypter::class);
        });

        $this->serviceProvider->boot();

        $result = $this->container->make(Rollout::class);
        $this->assertInstanceOf(Rollout::class, $result);
    }

    /**
     * @test
     */
    public function booting_registers_our_commands()
    {
        $serviceProvider = new TestServiceProvider($this->container);
        $serviceProvider->boot();

        $this->assertEquals(
            [
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
            ],
            $serviceProvider->commands
        );
    }
}

class TestServiceProvider extends ServiceProvider
{
    public $commands;

    public function commands($commands)
    {
        $this->commands = $commands;
    }
}
