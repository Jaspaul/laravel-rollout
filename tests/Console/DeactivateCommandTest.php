<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Helpers\User;
use Jaspaul\LaravelRollout\Drivers\Cache;

class DeactivateCommandTest extends TestCase
{
    /**
     * @test
     */
    function running_the_command_will_deactivate_the_feature_for_all_users()
    {
        $store = app()->make('cache.store')->getStore();

        $rollout = app()->make(Rollout::class);
        $rollout->activateUser('derp', new User("1"));
        $rollout->activatePercentage('derp', 82);

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('82|1||', $store->get('rollout.feature:derp'));

        Artisan::call('rollout:deactivate', [
            'feature' => 'derp'
        ]);

        $store = app()->make('cache.store')->getStore();

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('0|||', $store->get('rollout.feature:derp'));
    }
}
