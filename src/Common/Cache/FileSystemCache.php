<?php
/**
 * 文件缓存
 */
namespace Janssen\Rpc\Common\Cache;

use Janssen\Rpc\Common\OptionsAwareTrail;

class FileSystemCache implements CacheInterface
{
    /**
     * @var 文件缓存路径
     */
    private $cacheDir = '/tmp';

    public function set($key, $data)
    {
        $data = serialize($data);
        return (bool)file_put_contents($this->getFilePathByKey($key), $data);
    }

    /**
     * 获取缓存数据
     *
     * @param $key
     * @return mixed
     */
    public function get($key)
    {
        $path = $this->getFilePathByKey($key);
        if(!file_exists($path)) {
            return null;
        }
        $data = file_get_contents($path);
        return unserialize($data);
    }

    public function setCacheDir($dir)
    {
        $this->cacheDir = $dir;
    }

    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @param $key
     * @return string
     */
    private function getFilePathByKey($key)
    {
        return $this->getCacheDir() . '/rpc-token-cache-' . md5($key) . '.cache';
    }
}