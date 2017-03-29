<?php

namespace Jaspaul\LaravelRollout\Console;

use Opensoft\Rollout\Rollout;
use Illuminate\Console\Command;
use Jaspaul\LaravelRollout\FeaturePresenter;

class ListCommand extends Command
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
     * The rollout service.
     *
     * @var \Opensoft\Rollout\Rollout
     */
    protected $rollout;

    /**
     * Initialize our list features command with an instance of the rollout service.
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
     * Returns the feature rows.
     *
     * @return array
     *         A list of features.
     */
    public function getRows() : array
    {
        $rows = [];

        $features = $this->rollout->features();

        foreach ($features as $name)
        {
            $feature = new FeaturePresenter($this->rollout->get($name));

            $rows[] = [
                'name' => $feature->getName(),
                'status' => $feature->getDisplayStatus()
            ];
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
        $headers = ['name', 'status'];
        $rows = $this->getRows();

        $this->table($headers, $rows);
    }
}
