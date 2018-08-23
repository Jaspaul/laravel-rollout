<?php

namespace Tests;

use Opensoft\Rollout\Feature;
use Jaspaul\LaravelRollout\FeaturePresenter;

class FeaturePresenterTest extends TestCase
{
    /**
     * @test
     */
    public function get_name_returns_the_name_of_the_feature()
    {
        $feature = new Feature('name');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals('name', $presenter->getName());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_all_message_if_the_feature_is_100_percent_enabled()
    {
        $feature = new Feature('name');
        $feature->setPercentage(100);

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['all'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_request_parameter_message_if_only_a_request_parameter_is_set()
    {
        $feature = new Feature('name');
        $feature->setRequestParam('derp');

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['request_param'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_percentage_message_if_it_is_enabled_for_more_than_0_but_less_than_100_percent_of_users()
    {
        $feature = new Feature('name');
        $feature->setPercentage(80);

        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['percentage'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_groups()
    {
        $feature = new Feature('name', '0||d');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_users()
    {
        $feature = new Feature('name', '0|a|');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_display_status_returns_the_whitelist_message_if_it_is_enabled_for_users_and_groups()
    {
        $feature = new Feature('name', '0|a|d');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(FeaturePresenter::$statuses['whitelist'], $presenter->getDisplayStatus());
    }

    /**
     * @test
     */
    public function get_request_parameter_returns_an_emtpy_string_if_a_request_parameter_is_not_set_on_the_feature()
    {
        $feature = new Feature('name');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals('', $presenter->getRequestParameter());
    }

    /**
     * @test
     */
    public function get_request_parameter_returns_the_request_parameter_when_one_is_set()
    {
        $feature = new Feature('name', '0|a|d|param');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals('param', $presenter->getRequestParameter());
    }

    /**
     * @test
     */
    public function get_percentage_returns_the_percentage_of_users_the_feature_is_enabled_for()
    {
        $feature = new Feature('name');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(0, $presenter->getPercentage());

        $feature = new Feature('name', '88|a|d|param');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals(88, $presenter->getPercentage());
    }

    /**
     * @test
     */
    public function get_users_returns_an_empty_string_by_default()
    {
        $feature = new Feature('name');
        $presenter = new FeaturePresenter($feature);

        $this->assertEmpty($presenter->getUsers());
    }

    /**
     * @test
     */
    public function get_users_returns_a_comma_seperated_string_of_users()
    {
        $feature = new Feature('name', '0|user_1,user_2,user_3||param');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals('user_1, user_2, user_3', $presenter->getUsers());
    }

    /**
     * @test
     */
    public function to_array_returns_an_array_representation_of_the_underlying_feature()
    {
        $expected = [
            'name' => 'name',
            'status' => FeaturePresenter::$statuses['request_param'],
            'request-parameter' => 'param',
            'percentage' => 0,
            'users' => 'a',
            'groups' => 'd',
        ];

        $feature = new Feature('name', '0|a|d|param');
        $presenter = new FeaturePresenter($feature);

        $this->assertEquals($expected, $presenter->toArray());
    }
}
