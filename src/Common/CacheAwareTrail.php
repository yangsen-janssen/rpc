<?php
/**
 * cache trait
 */

namespace Janssen\Rpc\Common;


trait CacheAwareTrail
{
    /**
     * @var callable
     */
    protected $cachePool;

    public function setCache($cache)
    {
        $this->cachePool = $cache;
    }

    public function getCache()
    {
        return $this->cachePool;
    }
}