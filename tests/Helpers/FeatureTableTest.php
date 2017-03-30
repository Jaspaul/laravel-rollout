<?php

namespace Tests\Helpers;

use Tests\TestCase;
use Opensoft\Rollout\Feature;
use Illuminate\Support\Collection;
use Jaspaul\LaravelRollout\FeaturePresenter;
use Jaspaul\LaravelRollout\Helpers\FeatureTable;

class FeatureTableTest extends TestCase
{
    /**
     * @test
     */
    function get_headers_should_return_same_keys_as_the_feature_presenter_to_array_method()
    {
        $presenter = new FeaturePresenter(new Feature('test'));

        $table = new FeatureTable(new Collection());

        $this->assertSame(array_keys($presenter->toArray()), $table->getHeaders()->toArray());
    }

    /**
     * @test
     */
    function get_rows_will_only_return_rows_for_feature_presenters_in_the_collection()
    {
        $presenter = new FeaturePresenter(new Feature('test'));
        $collection = new Collection([$presenter, [], 'hi', 'alpha']);

        $table = new FeatureTable($collection);

        $this->assertEquals(1, $table->getRows()->count());
        $this->assertSame($presenter->toArray(), $table->getRows()->first());
    }
}
