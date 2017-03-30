<?php

namespace Jaspaul\LaravelRollout\Console;

class CreateCommand extends RolloutCommand
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
     * Creates the provided feature.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->argument('feature');
        $this->renderFeatureAsTable($name);
    }
}
