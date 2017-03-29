<?php

namespace Jaspaul\LaravelRollout\Drivers;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Contracts\Cache\Repository;
use Opensoft\Rollout\Storage\StorageInterface;

class Cache implements StorageInterface
{
    /**
     * An instance of a cache repository that we can store our keys in.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $repository;

    /**
     * The prefix for the cache key.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Configures our cache driver with an instance of the cache repository and
     * a key prefix.
     *
     * @param \Illuminate\Contracts\Cache\Repository $repository
     *        An instance of the cache repository.
     * @param string $prefix
     *        A prefix for the cache keys.
     */
    public function __construct(Repository $repository, string $prefix = 'rollout')
    {
        $this->repository = $repository;
        $this->prefix = $prefix;
    }

    /**
     * Prepends our key with the configured prefix.
     *
     * @param  string $key
     *         The key to prepend with the prefix.
     *
     * @return string
     *         The prefixed key.
     */
    private function prefixKey($key) : string
    {
        return sprintf('%s.%s', $this->prefix, $key);
    }

    /**
     * Get's the value corresponding to the provided key from the cache. Note
     * this function has the side effect of prepending the local prefix to the
     * key.
     *
     * @param string $key
     *        The key for the cached item.
     *
     * @return string|null
     *         Null if the value is not found
     */
    public function get($key)
    {
        return $this->repository->get($this->prefixKey($key), null);
    }

    /**
     * Store the provided key in the underlying cache layer. Note this function
     * has the side effect of prepending the local prefix to the ky.
     *
     * @param string $key
     *        The key to store the cache under.
     * @param string $value
     *        The value to bind to the key.
     *
     * @return void
     */
    public function set($key, $value)
    {
        $this->repository->forever($this->prefixKey($key), $value);
    }

    /**
     * Removes the given key from the cache. Note this will handle prefixing the
     * key before removal.
     *
     * @param string $key
     *        The key to remove.
     *
     * @return void
     */
    public function remove($key)
    {
        $this->repository->forget($this->prefixKey($key));
    }
}
