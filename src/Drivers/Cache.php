<?php

namespace Jaspaul\LaravelRollout\Drivers;

use Illuminate\Contracts\Cache\Store;
use Opensoft\Rollout\Storage\StorageInterface;

class Cache implements StorageInterface
{
    /**
     * An instance of a cache store that we can store our keys in.
     *
     * @var \Illuminate\Contracts\Cache\Store;
     */
    protected $store;

    /**
     * The prefix for the cache key.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Configures our cache driver with an instance of the cache store and a key
     * prefix.
     *
     * @param \Illuminate\Contracts\Cache\Store $store
     *        An instance of the cache store.
     * @param string $prefix
     *        A prefix for the cache keys.
     */
    public function __construct(Store $store, string $prefix = 'rollout')
    {
        $this->store = $store;
        $this->prefix = $prefix;
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
        $key = sprintf('%s.%s', $this->prefix, $key);
        return $this->store->get($key);
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
        $key = sprintf('%s.%s', $this->prefix, $key);
        $this->store->forever($key, $value);
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
        $key = sprintf('%s.%s', $this->prefix, $key);
        $this->store->forget($key);
    }
}
