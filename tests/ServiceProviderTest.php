<?php

namespace Tests;

use Mockery;
use Opensoft\Rollout\Rollout;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Repository;
use Jaspaul\LaravelRollout\ServiceProvider;
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
}
