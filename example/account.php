<?php

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config/dev.php';
$cache = new Janssen\Rpc\Common\Cache\DefaultCache();
$accessTokenObject = new Janssen\Rpc\Common\AccessToken($config);
$accessTokenObject->setCache($cache);

$accessTokenObject->getAccessToken();

$client = new \Janssen\Rpc\Client\Client($config);
$client->setAccessTokenGateway($accessTokenObject);
$response = $client->request('support.account', ['access_token'=> $accessTokenObject->getAccessToken()]);
var_dump($response);