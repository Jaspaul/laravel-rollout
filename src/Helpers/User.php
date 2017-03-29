<?php

namespace Jaspaul\LaravelRollout\Helpers;

use Jaspaul\LaravelRollout\Contracts\User as Contract;

class User implements Contract
{
    /**
     * The id of the user.
     *
     * @var string
     */
    protected $id;

    /**
     * Constructs our user helper with an id.
     *
     * @param string $id
     *        The id of the user.
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * The identifier to use with rollout.
     *
     * @return string
     *         The id.
     */
    public function getRolloutIdentifier()
    {
        return $this->id;
    }
}
