<?php

namespace Jaspaul\LaravelRollout\Console;

use Illuminate\Support\Collection;
use Jaspaul\LaravelRollout\FeaturePresenter;

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
     * Returns the feature rows.
     *
     * @return \Illuminate\Support\Collection
     *         A list of features.
     */
    protected function getRows() : Collection
    {
        return (new Collection($this->rollout->features()))
            ->map(function ($feature) {
                return new FeaturePresenter($this->rollout->get($feature));
            })->map(function (FeaturePresenter $feature) {
                return $feature->toArray();
            });
    }

    /**
     * Outputs a table containing the features configured in rollout.
     *
     * @return void
     */
    public function handle()
    {
        $headers = ['name', 'status', 'request-parameter', 'percentage', 'users'];
        $rows = $this->getRows();

        $this->table($headers, $rows);
    }
}
