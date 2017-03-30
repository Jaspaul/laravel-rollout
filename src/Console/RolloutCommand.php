<?php

namespace Jaspaul\LaravelRollout\Console;

use Opensoft\Rollout\Rollout;
use Illuminate\Console\Command;

abstract class RolloutCommand extends Command
{
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
     * Performs the logic for the command.
     *
     * @return void
     */
    abstract public function handle();
}
