<?php

namespace Jaspaul\LaravelRollout\Console;

use Illuminate\Support\Collection;
use Jaspaul\LaravelRollout\FeaturePresenter;
use Jaspaul\LaravelRollout\Helpers\FeatureTable;

class ListCommand extends RolloutCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollout:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns a list of all the features that have been created.';

    /**
     * Outputs a table containing the features configured in rollout.
     *
     * @return void
     */
    public function handle()
    {
        $presenters = (new Collection($this->rollout->features()))
            ->map(function ($feature) {
                return new FeaturePresenter($this->rollout->get($feature));
            });

        (new FeatureTable($presenters))->render($this);
    }
}
