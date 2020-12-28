<?php
/**
 * Access Token
 *
 * TODO 业务锁，防止重复强制刷新TOKEN
 */
namespace Janssen\Rpc\Common;

class AccessToken
{
    use LoggerAwareTrait, OptionsAwareTrail, CacheAwareTrail;

    /**
     * 认证网关前缀
     *
     * @var string
     */
    private $authUrlPrefix = 'http://support.local.janssen.com';

    /**
     * 客户端唯一识别ID
     * @var string
     */
    private $appId;

    /**
     * 认证秘钥
     * @var string
     */
    private $appSecret;

    /**
     * Token数据
     * @var array
     */
    private $token;

    public function __construct($options)
    {
        $this->setOptions($options);
    }

    /**
     * @param $appId
     */
    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    /**
     * @param $appSecret
     */
    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * 设置认证网关URL前缀
     *
     * @param $prefix
     * @return AccessToken
     */
    public function setAuthUrlPrefix($prefix)
    {
        $this->authUrlPrefix = $prefix;
        return $this;
    }

    /**
     * 获取认证access_token的地址
     *
     * @return string
     */
    private function getAuthUrl()
    {
        return $this->authUrlPrefix . '/rpc/rpc-token';
    }

    /**
     * 根据客户端账号信息获取秘钥信息
     *
     * @return array
     */
    protected function refreshToken()
    {
        $data = HttpUtils::request($this->getAuthUrl(), ['app_id'=> $this->appId, 'secret'=> $this->appSecret]);
        return $data;
    }

    /**
     * 获取用户秘钥信息
     *
     * @param bool $force
     * @return mixed
     */
    public function getAccessToken($force = false)
    {
        $token = $this->getAccessTokenFromCache();
        //检查有效期是否已过
        if($force || !$token || !isset($token['expiry_time']) || $token['expiry_time'] < time()) {
            $token = $this->refreshToken();
            $token['expiry_time'] = strtotime('+' . $token['expires_in'] . ' seconds');
            $this->setAccessTokenToCache($token);
        }
        return $token['access_token'];
    }

    /**
     * 获取缓存Token信息
     *
     * @return array|null
     */
    private function getAccessTokenFromCache()
    {
        if($cache = $this->getCache()) {
            return $cache->get($this->getCacheKey());
        }
    }

    /**
     * 保存access token到缓存
     *
     * @param $accessToken
     * @return $this
     */
    private function setAccessTokenToCache($accessToken)
    {
        if($cache = $this->getCache()) {
            $cache->set($this->getCacheKey(), $accessToken);
        }
        return $this;
    }

    private function getCacheKey()
    {
        return '_janssen-rpc-token-' . $this->appId;
    }
}