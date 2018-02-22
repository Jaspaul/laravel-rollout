<?php

namespace Jaspaul\LaravelRollout\Contracts;

use Opensoft\Rollout\RolloutUserInterface;

interface User extends RolloutUserInterface
{
    /**
     * Checks if user can access feature
     * @param $feature
     * @return boolean
     */
    public function featureEnabled($feature);

    /**
     * Checks if user cannot access feature
     * @param $feature
     * @return boolean
     */
    public function featureNotEnabled($feature);
}
