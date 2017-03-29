<?php

namespace Tests;

use Opensoft\Rollout\Feature;
use Jaspaul\LaravelRollout\FeaturePresenter;

class FeaturePresenterTest extends TestCase
{
    /**
     * @test
     */
    function get_name_returns_the_name_of_the_feature()
    {
        $feature = new Feature('name');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals('name', $presenter->getName());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_all_message_if_the_feature_is_100_percent_enabled()
    {
        $feature = new Feature('name');
        $feature->setPercentage(100);

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['all'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_request_parameter_message_if_only_a_request_parameter_is_set()
    {
        $feature = new Feature('name');
        $feature->setRequestParam('derp');

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['request_param'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_percentage_message_if_it_is_enabled_for_more_than_0_but_less_than_100_percent_of_users()
    {
        $feature = new Feature('name');
        $feature->setPercentage(80);

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['percentage'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_groups()
    {
        $feature = new Feature('name', '0||d');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_users()
    {
        $feature = new Feature('name', '0|a|');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_users_and_groups()
    {
        $feature = new Feature('name', '0|a|d');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }
}
