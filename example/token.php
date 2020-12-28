<?php
/**
 * get access token
 */

include __DIR__ . '/../vendor/autoload.php';

$config = include __DIR__ . '/config/dev.php';
$tokenConfig = [
    'auth_url_prefix' => 'http://support.local.xiaohuibang.com',
    'app_id' => 'app_id',
    'app_secret' => 'app_secret',
];
$accessTokenObject = new Janssen\Rpc\Common\AccessToken($tokenConfig);
$token = $accessTokenObject->getAccessToken();
var_dump($token);