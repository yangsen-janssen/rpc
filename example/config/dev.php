<?php
/**
 * 测试站的测试配置
 */

return [
    'app_id' => 'app_id',
    'app_secret' => 'app_secret',
    'auth_url_prefix' => 'http://support.test.janssen.cn',
    //items
    'items' => [
        'support.echo' => 'http://support.test.janssen.cn/rpc/rpc-echo', //测试回显
        'support.account' => 'http://support.test.janssen.cn/rpc/rpc-account/info-by-token', //集成项目必须要这个api
    ],
    //别名
    'alias' => [
        'rpc.echo' => 'support.echo',
        'rpc.account' => 'support.account',
    ],
];