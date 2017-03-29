<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Opensoft\Rollout\Rollout;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Jaspaul\LaravelRollout\Drivers\Cache;
use Jaspaul\LaravelRollout\Console\ListFeatures;

class ListFeaturesTest extends TestCase
{
    private $command;
    private $rollout;

    /**
     * @before
     */
    function setup_command()
    {
        $this->rollout = new Rollout(new Cache(new Repository(new ArrayStore())));
        $this->command = new ListFeatures($this->rollout);
    }

    /**
     * @test
     */
    function get_rows_returns_an_empty_set_when_no_features_exist()
    {
        $result = $this->command->getRows();
        $this->assertEmpty($result);
    }

    /**
     * @test
     */
    function get_rows_returns_the_features_that_were_set()
    {
        $this->rollout->get('test');

        $result = $this->command->getRows();

        $this->assertEquals(1, count($result));
        $this->assertEquals(
            [['name' => 'test', 'status' => 'Deactivated globally.']], $result
        );
    }
}
