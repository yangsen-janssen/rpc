<?php
/**
 * Http请求工具
 */
namespace Janssen\Rpc\Common;

class HttpUtils
{
    /**
     * 发起一个http请求
     *
     * @param $url
     * @param $getData
     * @param $postData
     * @param array $header
     * @param array $options
     * @return mixed
     */
    public static function request($url, $getData = [], $postData = [], $header = [], $options = [])
    {
        //请求方式
        $method = isset($options['method']) ? $options['method'] : 'POST';
        $method = strtoupper($method);
        //timeout
        $timeout = isset($options['timeout']) ? $options['timeout'] : 3; //默认三秒超时

        //get 参数处理
        $getParams = http_build_query($getData);
        $url .= '?' . $getParams;

        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);// 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        if($method == 'POST') {
            $data = http_build_query($postData);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        }
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            throw new \RuntimeException('Errno' . curl_error($curl));//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return json_decode($tmpInfo, true); //返回解压数据
    }
}