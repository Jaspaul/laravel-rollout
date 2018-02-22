<?php

namespace Jaspaul\LaravelRollout\Helpers;

use Jaspaul\LaravelRollout\Contracts\User as Contract;

class User implements Contract
{
    use InteractsWithRolloutTrait;

    /**
     * The id of the user.
     *
     * @var string
     */
    protected $userIdentifier;

    /**
     * Constructs our user helper with an id.
     *
     * @param string $userIdentifier
     *        The id of the user.
     */
    public function __construct(string $userIdentifier)
    {
        $this->userIdentifier = $userIdentifier;
    }

    /**
     * The identifier to use with rollout.
     *
     * @return string
     *         The id.
     */
    public function getRolloutIdentifier()
    {
        return $this->userIdentifier;
    }
}
