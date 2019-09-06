<?php

namespace Tests;

use Mockery;
use Orchestra\Testbench\TestCase as Base;
use Jaspaul\LaravelRollout\ServiceProvider;

abstract class TestCase extends Base
{
    /**
     * @before
     */
    protected function setUpMockery()
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * @after
     */
    protected function close_mockery()
    {
        Mockery::close();
    }
}
