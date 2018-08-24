<?php

namespace Jaspaul\LaravelRollout;

use Opensoft\Rollout\Feature;

class FeaturePresenter
{
    /**
     * A list of available status messages.
     *
     * @var array
     */
    public static $statuses = [
        'all' => 'Active for everyone.',
        'request_param' => 'Active with a request parameter.',
        'percentage' => 'Active via percentage rollout.',
        'whitelist' => 'Active via group or user whitelist.',
        'disabled' => 'Deactivated globally.'
    ];

    /**
     * The feature we're presenting.
     *
     * @var \Opensoft\Rollout\Feature
     */
    protected $feature;

    /**
     * Sets up our local feature.
     *
     * @param \Opensoft\Rollout\Feature $feature
     *        The feature to present.
     */
    public function __construct(Feature $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Returns the name to render for the feature.
     *
     * @return string
     *         The name of the feature.
     */
    public function getName() : string
    {
        return $this->feature->getName();
    }

    /**
     * Returns a human readable status for the feature.
     *
     * @return string
     *         The status of the feature.
     */
    public function getDisplayStatus() : string
    {
        if ($this->feature->getPercentage() === 100) {
            return self::$statuses['all'];
        }

        if ($this->feature->getRequestParam()) {
            return self::$statuses['request_param'];
        }

        if ($this->feature->getPercentage() > 0) {
            return self::$statuses['percentage'];
        }

        if (count($this->feature->getGroups()) > 0 || count($this->feature->getUsers()) > 0) {
            return self::$statuses['whitelist'];
        }

        return self::$statuses['disabled'];
    }

    /**
     * Returns the request parameter if one is available for enabling the
     * feature.
     *
     * @return string
     *         The request parameter if it's available, empty string otherwise.
     */
    public function getRequestParameter() : string
    {
        return $this->feature->getRequestParam() ?: '';
    }

    /**
     * Returns the percentage the feature is enabled for.
     *
     * @return int
     *         The whole percentage of users that have the feature enabled.
     */
    public function getPercentage() : int
    {
        return (int) $this->feature->getPercentage();
    }

    /**
     * Returns a list of the users that have this feature enabled.
     *
     * @return string
     */
    public function getUsers() : string
    {
        return implode(', ', $this->feature->getUsers());
    }

    /**
     * Returns a list of the groups that have this feature enabled.
     *
     * @return string
     */
    public function getGroups() : string
    {
        return implode(', ', $this->feature->getGroups());
    }

    /**
     * Returns an array representation of the feature presenter.
     *
     * @return array
     */
    public function toArray() : array
    {
        return [
            'name' => $this->getName(),
            'status' => $this->getDisplayStatus(),
            'request-parameter' => $this->getRequestParameter(),
            'percentage' => $this->getPercentage(),
            'users' => $this->getUsers(),
            'groups' => $this->getGroups(),
        ];
    }
}
