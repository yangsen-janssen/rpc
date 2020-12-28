<?php

namespace Janssen\Rpc\Common\Cache;


interface CacheInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * set cache
     *
     * @param $key
     * @param $data
     * @return mixed
     */
    public function set($key, $data);
}