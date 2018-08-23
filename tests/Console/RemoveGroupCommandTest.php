<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Jaspaul\LaravelRollout\Helpers\User;
use Jaspaul\LaravelRollout\Drivers\Cache;

class RemoveGroupCommandTest extends TestCase
{
    /**
     * @test
     */
    public function running_the_command_with_a_feature_will_remove_the_corresponding_user()
    {
        $store = app()->make('cache.store')->getStore();

        $rollout = app()->make(Rollout::class);
        $rollout->activateGroup('derp', 'ballers');

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('0||ballers|', $store->get('rollout.feature:derp'));

        Artisan::call('rollout:remove-group', [
            'feature' => 'derp',
            'group' => 'ballers'
        ]);

        $this->assertEquals('derp', $store->get('rollout.feature:__features__'));
        $this->assertEquals('0|||', $store->get('rollout.feature:derp'));
    }
}
