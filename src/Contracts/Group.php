<?php

namespace Jaspaul\LaravelRollout\Contracts;

use Opensoft\Rollout\RolloutUserInterface;

interface Group
{
    /**
     * The name of the group.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Checks if the given user is a member of this group.
     *
     * @param mixed $user
     *
     * @return boolean
     */
    public function hasMember($user = null): bool;
}
