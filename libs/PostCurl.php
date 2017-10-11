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
            //额外options
            $a_extraOpts = [
                CURLOPT_POST, TRUE,
                CURLOPT_POSTFIELDS, $this->o_requestData->createData(),
            ];
            $this->setOpts($a_extraOpts);
            return parent::sendRequest();
        }
    }