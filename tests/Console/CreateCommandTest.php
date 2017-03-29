<?php

namespace Tests\Drivers;

use Mockery;
use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;
use Jaspaul\LaravelRollout\Console\CreateCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

class CreateCommandTest extends TestCase
{
    /**
     * @test
     */
    function running_the_command_with_a_feature_will_create_the_corresponding_feature()
    {
        Artisan::call('rollout:create', [
            'feature' => 'derp'
        ]);

        $store = app()->make('cache.store')->getStore();

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('0|||', $store->get('rollout.feature:derp'));
    }
}
