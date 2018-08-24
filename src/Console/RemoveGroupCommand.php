<?php

namespace Jaspaul\LaravelRollout\Console;

use Jaspaul\LaravelRollout\Helpers\User;

class RemoveGroupCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:remove-group {feature} {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes the provided group from the feature.';

    /**
     * Removes the provided user from the feature. Note this will create
     * the feature as a side effect.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $group = $this->argument('group');

        $this->rollout->deactivateGroup($name, $group);

        $this->renderFeatureAsTable($name);
    }
}
