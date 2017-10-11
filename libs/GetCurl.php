<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/6
     * Time: 22:26
     */

    namespace curl\libs;


    class GetCurl extends Curl
    {

        /**
         * 发送请求
         * @return mixed
         */
        public function sendRequest() {
            //1.设置请求地址
            $s_param = $this->o_requestData->createData();
            if (!empty($s_param)):
                $this->s_requestUrl .= '?' . $s_param;
            endif;
            //设置curl options
            $this->setOpts();
            //执行操作获取结果
            return parent::sendRequest();
        }
    }
