<?php

namespace Jaspaul\LaravelRollout\Console;

use Opensoft\Rollout\Rollout;
use Illuminate\Console\Command;

class CreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:create {feature}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a feature with the provided name.';

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
        $this->rollout->get($name);
    }
}
