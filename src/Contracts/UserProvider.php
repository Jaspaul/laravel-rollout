<?php

namespace Jaspaul\LaravelRollout\Contracts;

interface UserProvider
{
    /**
     * Finds and returns rollout users.
     *
     * @param mixed $id
     *        A unique identifier for the rollout user in the system.
     *
     * @return \Jaspaul\LaravelRollout\Contracts\User
     *         A rollout user.
     */
    public function findByRolloutIdentifier($id);
}
