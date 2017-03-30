<?php

namespace Jaspaul\LaravelRollout\Console;

use Opensoft\Rollout\Rollout;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Jaspaul\LaravelRollout\FeaturePresenter;
use Jaspaul\LaravelRollout\Helpers\FeatureTable;

abstract class RolloutCommand extends Command
{
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
     * Renders the feature as a table.
     *
     * @param  string $name
     *         The name of the feature.
     *
     * @return void
     */
    public function renderFeatureAsTable(string $name)
    {
        $presenters = (new Collection([$name]))
            ->map(function ($feature) {
                return new FeaturePresenter($this->rollout->get($feature));
            });

        (new FeatureTable($presenters))->render($this);
    }

    /**
     * Performs the logic for the command.
     *
     * @return void
     */
    abstract public function handle();
}
