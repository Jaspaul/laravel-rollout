<?php

namespace Tests\Helpers;

use Tests\TestCase;
use Jaspaul\LaravelRollout\Helpers\User;

class UserTest extends TestCase
{
    /**
     * @test
     */
    function get_rollout_identifier_returns_the_id_the_user_was_constructed_with()
    {
        $id = "id";

        $user = new User($id);

        $this->assertEquals($id, $user->getRolloutIdentifier());
    }
}
