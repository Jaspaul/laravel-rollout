<?php

namespace Jaspaul\LaravelRollout\Helpers;

use Opensoft\Rollout\Feature;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Jaspaul\LaravelRollout\FeaturePresenter;

class FeatureTable
{
    /**
     * The presenters to render into a table.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $presenters;

    /**
     * Filters the provided collection into presenters. It also grabs the first
     * presenter and generates the headers from it's properties.
     *
     * @param \Illuminate\Support\Collection $presenters
     *        A list of presenters to render into a table.
     */
    public function __construct(Collection $presenters) {
        $this->presenters = $presenters->filter(function ($presenter) {
            return $presenter instanceof FeaturePresenter;
        });
    }

    /**
     * Returns the key's for the feature array.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getHeaders() : Collection
    {
        $presenter = new FeaturePresenter(new Feature(''));
        return new Collection(array_keys($presenter->toArray()));
    }

    /**
     * Returns each presenter as it's array representation.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRows() : Collection
    {
        return $this->presenters->map(function (FeaturePresenter $feature) {
            return $feature->toArray();
        });
    }

    /**
     * Renders itself as a table through the provided command.
     *
     * @param  \Illuminate\Console\Command $command
     *         The command to render the table into.
     *
     * @return void
     */
    public function render(Command $command)
    {
        $command->table($this->getHeaders()->toArray(), $this->getRows()->toArray());
    }
}
