<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 12:16
     */

    namespace curl\libs;

    /**
     * CURL指挥类L
     * Class CurlComposer
     * @package curl\libs
     */
    class CurlComposer
    {
        private $s_requestUrl;//请求地址
        private $s_type;//请求类型
        private $a_data;//请求数据
        private $a_SSL;//SSL验证相关,不需要SSL证书验证不需要填入
        public  $s_errorMsg;//错误信息

        public function __construct($s_requestUrl, $s_type, array $a_data = [], array $a_SSL = []) {
            $this->s_requestUrl = $s_requestUrl;
            $this->s_type = strtolower($s_type);
            $this->a_data = $a_data;
            $this->a_SSL = $a_SSL;
        }

        public function sendRequest() {
            try {
                //1.验证请求参数
                $this->verifyParams();
                //2.实例化请求对香
                switch ($this->s_type):
                    case 'get':
                        $o_input = new GetRequestData($this->a_data);
                        $o_curl = new GetCurl($this->s_requestUrl, $o_input);
                    break;
                    case 'post':
                        $o_input = new PostRequestData($this->a_data);
                        $o_curl = new PostCurl($this->s_requestUrl, $o_input);
                    break;
                    case 'xml':
                        $o_input = new XmlRequestData($this->a_data);
                        $o_curl = new XmlCurl($this->s_requestUrl, $o_input);
                    break;
                    case 'json':
                        $o_input = new JsonRequestData($this->a_data);
                        $o_curl = new JsonCurl($this->s_requestUrl, $o_input);
                    break;
                endswitch;
                if (isset($o_curl)):
                    //SSL设置,根据用户是否传入SSL证书以及私钥文件
                    $o_curl->setSSL(!empty($this->a_SSL), $this->a_SSL);
                    return $o_curl->sendRequest();
                else:
                    return NULL;
                endif;
            } catch (\Exception $e) {
                $this->s_errorMsg = $e->getMessage();

                return FALSE;
            }
        }

        /**
         * 验证请求参数，请求地址和类型为必填
         * @throws \Exception
         */
        public function verifyParams() {
            if (empty($this->s_requestUrl)) :
                throw new \Exception("请求地址为必填参数！");
            endif;
            if (empty($this->s_type)) :
                throw new \Exception("请求类型为必填参数！");
            endif;
            if (!in_array($this->s_type, ['get', 'post', 'json', 'xml'])):
                throw new \Exception("请求类型(" . $this->s_type . ")错误！");
            endif;
        }

        /**
         * 获取错误信息
         * @return mixed
         */
        public function getErrorMsg() {
            return $this->s_errorMsg;
        }
    }