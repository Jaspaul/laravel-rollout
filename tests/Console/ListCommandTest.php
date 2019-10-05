<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Feature;
use Opensoft\Rollout\Rollout;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Console\Kernel;
use Jaspaul\LaravelRollout\FeaturePresenter;

class ListCommandTest extends TestCase
{
    /**
     * @test
     */
    function it_returns_an_empty_table_if_there_are_no_stored_features()
    {
        Artisan::call('rollout:list', []);

        $output = $this->app[Kernel::class]->output();
        $output = explode("\n", $output);

        $this->assertEquals(4, count($output));

        // The first row is a header row +----+----+ ...
        $this->assertTrue((bool) preg_match('/[+-]+/', $output[0]));

        // The second row contains each of the keys for a feature presenter
        $presenter = new FeaturePresenter(new Feature(''));
        foreach (array_keys($presenter->toArray()) as $key) {
            $this->assertStringContainsString($key, $output[1]);
        }

        // The first row is a seperator row +----+----+ ...
        $this->assertTrue((bool) preg_match('/[+-]+/', $output[2]));
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

        $this->assertStringContainsString('derp', $output);
        $this->assertStringContainsString(FeaturePresenter::$statuses['disabled'], $output);
    }
}
