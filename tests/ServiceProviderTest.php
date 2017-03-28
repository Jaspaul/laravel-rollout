<?php

namespace Tests;

use Mockery;
use Jaspaul\LaravelRollout\ServiceProvider;
use Illuminate\Contracts\Container\Container;
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
        $this->container = Mockery::mock(Container::class);
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
}
