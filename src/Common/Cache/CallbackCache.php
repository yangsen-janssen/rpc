<?php
/**
 * 回调
 */
namespace Janssen\Rpc\Common\Cache;

class CallbackCache implements CacheInterface
{
    private $getCallback;

    private $setCallback;

    /**
     * 设置获取回调方法
     *
     * @param $callback
     */
    public function setGetCallback($callback)
    {
        $this->getCallback = $callback;
    }

    /**
     * 设置保存缓存回调
     *
     * @param $callback
     */
    public function setSetCallback($callback)
    {
        $this->setCallback = $callback;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        return call_user_func($this->getCallback, $key);
    }

    /**
     * @param $key
     * @param $data
     * @return mixed
     */
    public function set($key, $data)
    {
        return call_user_func($this->setGetCallback, [$key, $data]);
    }
}