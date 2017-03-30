<?php

namespace Tests\Drivers;

use Tests\TestCase;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Jaspaul\LaravelRollout\Drivers\Cache;

class CacheTest extends TestCase
{
    private $prefix = 'testing';

    private $repository;
    private $cache;

    /**
     * @before
     */
    function setup_cache()
    {
        $this->repository = new Repository(new ArrayStore());
        $this->cache = new Cache($this->repository, $this->prefix);
    }

    /**
     * @test
     */
    function ensure_the_cache_can_be_constructed()
    {
        $this->assertInstanceOf(Cache::class, $this->cache);
    }

    /**
     * @test
     */
    function get_returns_null_if_the_cache_does_not_have_the_requested_key()
    {
        $this->assertNull($this->cache->get('key'));
    }

    /**
     * @test
     */
    function once_set_you_can_get_the_value_back_with_the_same_key()
    {
        $key = 'key';
        $value = 'value';

        $this->cache->set($key, $value);
        $this->assertSame($value, $this->cache->get($key));
    }

    /**
     * @test
     */
    function once_you_remove_a_value_you_will_not_be_able_to_retrieve_it_from_the_store()
    {
        $key = 'key';
        $value = 'value';

        $this->cache->set($key, $value);
        $this->assertSame($value, $this->cache->get($key));

        $this->cache->remove($key);
        $this->assertNull($this->cache->get($key));
    }
}
