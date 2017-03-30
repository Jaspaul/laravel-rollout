<?php

namespace Jaspaul\LaravelRollout\Console;

use Jaspaul\LaravelRollout\Helpers\User;

class DeactivateCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:deactivate {feature}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivates the provided feature for everyone at once.';

    /**
     * Deactivates the feature for everyone.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $this->rollout->deactivate($name);
        $this->renderFeatureAsTable($name);
    }
}
