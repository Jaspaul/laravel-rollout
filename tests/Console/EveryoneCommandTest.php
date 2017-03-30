<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Drivers\Cache;

class EveryoneCommandTest extends TestCase
{
    /**
     * @test
     */
    function running_the_command_with_a_feature_will_set_the_rollout_percentage_to_100()
    {
        Artisan::call('rollout:everyone', [
            'feature' => 'derp'
        ]);

        $store = app()->make('cache.store')->getStore();

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('100|||', $store->get('rollout.feature:derp'));
    }
}
