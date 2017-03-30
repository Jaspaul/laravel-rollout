<?php

namespace Tests;

use Mockery;
use Opensoft\Rollout\Rollout;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository;
use Jaspaul\LaravelRollout\ServiceProvider;
use Jaspaul\LaravelRollout\Console\ListCommand;
use Jaspaul\LaravelRollout\Console\CreateCommand;
use Jaspaul\LaravelRollout\Console\DeleteCommand;
use Jaspaul\LaravelRollout\Console\AddUserCommand;
use Jaspaul\LaravelRollout\Console\EveryoneCommand;
use Jaspaul\LaravelRollout\Console\RemoveUserCommand;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProviderTest extends TestCase
{
    private $container;
    private $serviceProvider;

    /**
     * @before
     */
    function setup_service_provider()
    {
        $this->container = Container::getInstance();
        $this->serviceProvider = new ServiceProvider($this->container);
    }

    /**
     * @test
     */
    function ensure_a_service_provider_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->serviceProvider);
        $this->assertInstanceOf(IlluminateServiceProvider::class, $this->serviceProvider);
    }

    /**
     * @test
     */
    function booting_registers_a_rollout_singleton_into_the_container()
    {
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
    function booting_registers_our_commands()
    {
        $this->container->singleton('cache.store', function ($app) {
            return Mockery::mock(Repository::class);
        });

        $serviceProvider = new TestServiceProvider($this->container);
        $serviceProvider->boot();

        $this->assertEquals(
            [
                AddUserCommand::class,
                CreateCommand::class,
                DeleteCommand::class,
                EveryoneCommand::class,
                ListCommand::class,
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
