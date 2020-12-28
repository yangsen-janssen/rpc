<?php
/**
 * 默认内存缓存
 */
namespace Janssen\Rpc\Common\Cache;

class DefaultCache implements CacheInterface
{
    private $data = [];

    /**
     * 设置缓存
     *
     * @param $key
     * @param $data
     */
    public function set($key, $data)
    {
        $this->data[$key] = $data;
    }

    /**
     * 获取指定缓存
     *
     * @param $key
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}