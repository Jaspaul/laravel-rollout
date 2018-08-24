<?php

namespace Tests\Doubles;

use Tests\TestCase;
use Jaspaul\LaravelRollout\Contracts\Group;

class SampleGroup implements Group
{
    /**
     * The name of the group.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'sample-group';
    }

    /**
     * Defines the rule membership in the group.
     *
     * @param mixed $user
     *
     * @return boolean
     */
    public function hasMember($user = null): bool
    {
        return true;
    }
}
