<?php
/**
 * Created by PhpStorm.
 * User: ETH
 * Date: 2018/11/1
 * Time: 10:38
 */

include __DIR__ . '/../vendor/autoload.php';
$config = include __DIR__ . '/config/dev.php';

//实例化token
$cache = new Janssen\Rpc\Common\Cache\DefaultCache();
$accessTokenObject = new Janssen\Rpc\Common\AccessToken($config);
$accessTokenObject->setCache($cache);

$server = new Janssen\Rpc\Server\Server($config);
$server->setCache($cache);

//服务端检查token是否有效
$account = $server->checkToken($accessTokenObject->getAccessToken());
var_dump($account);