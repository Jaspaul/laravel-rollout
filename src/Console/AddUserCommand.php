<?php

namespace Jaspaul\LaravelRollout\Console;

use Opensoft\Rollout\Rollout;
use Illuminate\Console\Command;
use Jaspaul\LaravelRollout\Helpers\User;

class AddUserCommand extends Command
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
     * The rollout service.
     *
     * @var \Opensoft\Rollout\Rollout
     */
    protected $rollout;

    /**
     * Initialize our create feature command with an instance of the rollout
     * service.
     *
     * @param \Opensoft\Rollout\Rollout $rollout
     *        The rollout service.
     */
    public function __construct(Rollout $rollout)
    {
        parent::__construct();
        $this->rollout = $rollout;
    }

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
