<?php

namespace Jaspaul\LaravelRollout\Console;

use Jaspaul\LaravelRollout\Helpers\User;

class EveryoneCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:everyone {feature}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rolls out the feature to all of the users in the system.';

    /**
     * Updates the feature to rollout to 100% of users!
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $this->rollout->activatePercentage($name, 100);
        $this->renderFeatureAsTable($name);
    }
}
