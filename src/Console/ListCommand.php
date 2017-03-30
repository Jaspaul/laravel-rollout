<?php

namespace Jaspaul\LaravelRollout\Console;

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
     * @return array
     *         A list of features.
     */
    protected function getRows() : array
    {
        $rows = [];

        $features = $this->rollout->features();

        foreach ($features as $name)
        {
            $feature = new FeaturePresenter($this->rollout->get($name));
            $rows[] = $feature->toArray();
        }

        return $rows;
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
