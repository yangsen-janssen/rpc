<?php
/**
 * 服务器端处理
 */
namespace Janssen\Rpc\Server;

use Janssen\Rpc\Common\OptionsAwareTrail;
use Janssen\Rpc\Common\CacheAwareTrail;

class Server
{
    use OptionsAwareTrail, CacheAwareTrail;

    /**
     * @var array
     */
    private $config;

    public function __construct($config = [])
    {
        $this->setOptions($config);
        $this->config = $config;
    }

    /**
     * 获取客户端账户信息
     *
     * @param string $token
     * @return array
     */
    private function getClientAccountByToken($token)
    {
        $accessTokenObject = new \Bang\Rpc\Common\AccessToken($this->config);
        $client = new \Bang\Rpc\Client\Client($this->config);
        $client->setAccessTokenGateway($accessTokenObject);
        $response = $client->request('rpc.account', ['access_token'=>$token]);
        return $response;
    }

    /**
     * 检查Token是否有效
     */
    public function checkToken($token)
    {
        $account = $this->getTokenAccountWithCache($token);
        if(!$account) {
            return false;
        }
        //过期时间检查
        if(strtotime($account['expires_date_time'])<time()) {
            return false;
        }

        return true;
    }

    /**
     * 通过cache获取access token账号
     *
     * @param $token
     * @return array|null
     */
    public function getTokenAccountWithCache($token)
    {
        $account = null;
        if($this->getCache()) {
            $account = $this->getCache()->get('account.'.$token);
        }
        if(!$account) {
            $account = $this->getClientAccountByToken($token);
            if($this->getCache()) {
                $this->getCache()->set('account.'.$token, $account);
            }
        }
        return $account;
    }
}