<?php
/**
 * Rpc客户端
 */
namespace Janssen\Rpc\Client;

use Janssen\Rpc\Common\OptionsAwareTrail;
use Janssen\Rpc\Common\HttpUtils;

class Client
{
    use OptionsAwareTrail;

    /**
     * @var array
     */
    private $config;

    /**
     * @var \Janssen\Rpc\Common\AccessToken
     */
    private $accessTokenGateway;

    public function __construct($options = [])
    {
        $this->config = $options;
    }

    /**
     * @param $callback
     * @return $this
     */
    public function setAccessTokenGateway($callback)
    {
        $this->accessTokenGateway = $callback;
        return $this;
    }

    /**
     * @return \Janssen\Rpc\Common\AccessToken
     */
    public function getAccessTokenGateway()
    {
        return $this->accessTokenGateway;
    }

    /**
     * 发起远程调用
     *
     * @param $requestName
     * @param $data
     * @return mixed
     */
    public function request($requestName, $data)
    {
        $forceToken = false;
        $requestCount = 0;
        do {
            $requestCount++;
            $getData = [];
            $getData['access_token'] = $this->getAccessTokenGateway()->getAccessToken($forceToken);
            $url = $this->getUrlByRequestName($requestName);
            if(!$url) {
                throw new \RuntimeException('找不到对应的Api配置； request name:' . $requestName);
            }
            $response = HttpUtils::request($url, $getData, $data);
            //检查是否token过期
            if(isset($response['code']) && $response['code'] == 1001) {
                $forceToken = true;
                continue;
            }

            return $response;
            //重试次数不超过三次
            //TODO 从配置文件配置尝试次数
        } while($requestCount <= 3);
    }

    /**
     * 获取用户请求地址
     *
     * @param $name
     * @return null
     */
    private function getUrlByRequestName($name)
    {
        $name = $this->resolveAlias($name);
        return isset($this->config['items'][$name]) ? $this->config['items'][$name] : null;
    }

    /**
     * 解析别名
     *
     * @param $name
     * @return mixed
     */
    private function resolveAlias($name)
    {
        $aliasName = $name;
        while(isset($this->config['alias'][$aliasName])) {
            $aliasName = $this->config['alias'][$aliasName];
        }
        return $aliasName;
    }
}