<?php

namespace Jaspaul\LaravelRollout\Console;

class AddGroupCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:add-group {feature} {group}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enables the provided feature for the group.';

    /**
     * Adds the provided group to the requested feature. Note this will create
     * the feature as a side effect.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $group = $this->argument('group');

        $this->rollout->activateGroup($name, $group);

        $this->renderFeatureAsTable($name);
    }
}
