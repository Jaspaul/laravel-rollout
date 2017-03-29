<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Jaspaul\LaravelRollout\FeaturePresenter;
use Jaspaul\LaravelRollout\Console\ListCommand;

class ListCommandTest extends TestCase
{
    /**
     * @test
     */
    function it_returns_an_empty_table_if_there_are_no_stored_features()
    {
        $expected = "+------+--------+-------------------+------------+-------+
| name | status | request-parameter | percentage | users |
+------+--------+-------------------+------------+-------+
";

        Artisan::call('rollout:list', []);

        $output = $this->app[Kernel::class]->output();

        $this->assertSame($expected, $output);
    }

    /**
     * @test
     */
    function it_returns_the_stored_features_in_the_table()
    {
        $rollout = $this->app[Rollout::class];

        // Create our feature flag if it doesn't exist
        $rollout->get('derp');

        Artisan::call('rollout:list', []);

        $output = $this->app[Kernel::class]->output();

        $this->assertContains('derp', $output);
        $this->assertContains(FeaturePresenter::$statuses['disabled'], $output);
    }
}
