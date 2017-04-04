<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Drivers\Cache;

class PercentageCommandTest extends TestCase
{
    /**
     * @test
     */
    function running_the_command_will_update_the_percentage_to_the_provided_value()
    {
        Artisan::call('rollout:percentage', [
            'feature' => 'derp',
            'percentage' => 88
        ]);

        $store = app()->make('cache.store')->getStore();

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('88|||', $store->get('rollout.feature:derp'));
    }
}
