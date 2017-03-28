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
        $this->serviceProvider = new ResettableServiceProvider($this->container);
    }

    /**
     * @after
     */
    function reset_publish_list()
    {
        ResettableServiceProvider::$publishes = [];
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
    function when_running_in_the_console_it_adds_its_configuration_to_the_paths_to_publish()
    {
        $this->container->shouldReceive('runningInConsole')
            ->andReturn(true);
        $this->container->shouldReceive('make')
            ->with('path.config')
            ->andReturn('/this/is/a/path');
        $this->serviceProvider->register();

        $paths = ResettableServiceProvider::pathsToPublish();

        $this->assertNotEmpty($paths);
        $this->assertEquals(1, count($paths));
    }

    /**
     * @test
     */
    function when_running_outside_of_the_console_its_configuration_is_not_added_to_the_paths_to_publish()
    {
        $this->container->shouldReceive('runningInConsole')
            ->andReturn(false);
        $this->serviceProvider->register();

        $paths = ResettableServiceProvider::pathsToPublish();

        $this->assertEmpty($paths);
    }
}

class ResettableServiceProvider extends ServiceProvider
{
    /**
     * The paths that should be published.
     *
     * @var array
     */
    public static $publishes = [];
}
