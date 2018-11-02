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
            //额外 options
            $a_extraOpts = [
                CURLOPT_POST       => TRUE,
                CURLOPT_HTTPHEADER => [//头
                    'Content-Type: application/xml',
                    'Content-Length: ' . strlen($s_data),
                ],
                CURLOPT_POSTFIELDS => $s_data,//字段
            ];
            $this->setOpts($a_extraOpts);
            return parent::sendRequest();
        }
    }