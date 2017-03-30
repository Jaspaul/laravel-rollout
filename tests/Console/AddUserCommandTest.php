<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Drivers\Cache;

class AddUserCommandTest extends TestCase
{
    /**
     * @test
     */
    function running_the_command_with_a_feature_will_create_the_corresponding_feature()
    {
        Artisan::call('rollout:add-user', [
            'feature' => 'derp',
            'user' => 1
        ]);

        $store = app()->make('cache.store')->getStore();

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('0|1||', $store->get('rollout.feature:derp'));
    }
}
