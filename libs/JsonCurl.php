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
            //额外options
            $a_extraOpts = [
                CURLOPT_POST       => TRUE, //请求类型
                CURLOPT_HTTPHEADER => [//请求头
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($s_data),

                ],
                CURLOPT_POSTFIELDS => $s_data,//请求字段
            ];
            $this->setOpts($a_extraOpts);
            return parent::sendRequest();
        }
    }