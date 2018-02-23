<?php

namespace Jaspaul\LaravelRollout\Helpers;

use Opensoft\Rollout\Rollout;

trait InteractsWithRolloutTrait
{

    /**
     * Checks if user can access feature
     * @param $feature
     * @return boolean
     */
    public function featureEnabled($feature)
    {
        return app(Rollout::class)->isActive($feature, $this);
    }

    /**
     * Checks if user cannot access feature
     * @param $feature
     * @return boolean
     */
    public function featureNotEnabled($feature)
    {
        return ! app(Rollout::class)->isActive($feature, $this);
    }

}