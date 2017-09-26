<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 10:56
     */

    namespace curl\libs;

    /**
     * 发送一个POST请求，数据类型为JSON
     * Class CurlJson
     * @package curl\libs
     */
    class JsonCurl extends Curl
    {
        public function sendRequest() {
            //请求的数据
            $s_data = $this->o_requestData->createData();
            //1.设置请求地址
            curl_setopt($this->r_curl, CURLOPT_URL, $this->s_requestUrl);
            //2.设置请求类型
            curl_setopt($this->r_curl, CURLOPT_POST, TRUE);
            //3.设置请求头
            curl_setopt($this->r_curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($s_data),
            ]);
            //4.设置请求数据
            curl_setopt($this->r_curl, CURLOPT_POSTFIELDS, $s_data);


            return curl_exec($this->r_curl);
        }
    }