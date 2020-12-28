<?php
/**
 * echo 例子
 */

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config/dev.php';
$accessTokenObject = new Janssen\Rpc\Common\AccessToken($config);

$cache = new Janssen\Rpc\Common\Cache\DefaultCache();
$accessTokenObject->setCache($cache);

$client = new \Janssen\Rpc\Client\Client($config);
$client->setAccessTokenGateway($accessTokenObject);
$response = $client->request('rpc.echo', ['echo'=>'hello world']);
var_dump($response);