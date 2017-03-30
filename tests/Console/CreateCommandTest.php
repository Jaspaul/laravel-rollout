<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Drivers\Cache;

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
