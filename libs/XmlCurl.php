<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 11:06
     */

    namespace curl\libs;

    /**
     * 通过POST请求发送一个XML数据包
     * Class CurlXml
     * @package curl\libs
     */
    class XmlCurl extends Curl
    {
        public function sendRequest() {
            //请求数据
            $s_data = $this->o_requestData->createData();
            //1.设置请求地址
            curl_setopt($this->r_curl, CURLOPT_URL, $this->s_requestUrl);
            //2.设置请求方式
            curl_setopt($this->r_curl, CURLOPT_POST, TRUE);
            //3.设置请求格式
            curl_setopt($this->r_curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/xml',
                'Content-Length: ' . strlen($s_data),
            ]);
            //4.设置请求数据
            curl_setopt($this->r_curl, CURLOPT_POSTFIELDS, $s_data);

            return curl_exec($this->r_curl);
        }
    }