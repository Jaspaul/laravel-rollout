<?php

namespace Jaspaul\LaravelRollout\Console;

use Jaspaul\LaravelRollout\Helpers\User;

class AddUserCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:add-user {feature} {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds the provided user id to the feature.';

    /**
     * Creates the provided feature.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $id = $this->argument('user');

        $feature = $this->rollout->activateUser($name, new User($id));
    }
}
