<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 10:41
     */

    namespace curl\libs;


    class PostCurl extends Curl
    {
        public function sendRequest() {
            //1.设置请求地址
            curl_setopt($this->r_curl, CURLOPT_URL, $this->s_requestUrl);
            //1.设置请求方式为POST
            curl_setopt($this->r_curl, CURLOPT_POST, TRUE);
            //2.设置请求数据
            curl_setopt($this->r_curl, CURLOPT_POSTFIELDS, $this->o_requestData->createData());

            return curl_exec($this->r_curl);
        }
    }