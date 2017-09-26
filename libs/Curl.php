<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/6
     * Time: 22:20
     */

    namespace curl\libs;


    abstract class Curl
    {
        protected $s_requestUrl;//请求地址
        protected $o_requestData;//请对数据对象
        protected $r_curl;//请求资源
        protected $b_SSL           = FALSE;//验证证书
        protected $s_SSL_CERT_TYPE = 'PEM';//证书类型
        protected $s_SSL_CERT      = '';//路径
        protected $s_SSL_KEY_TYPE  = 'PEM';//私钥加密类型
        protected $s_SSL_KEY       = '';//私钥文件路径

        /**
         * Curl constructor.
         *
         * @param             $s_url
         * @param RequestData $o_requestData
         */
        public function __construct($s_url, RequestData $o_requestData) {
            $this->__init();
            $this->s_requestUrl = $s_url;
            $this->o_requestData = $o_requestData;
            //1.curl初始化
            $this->r_curl = curl_init();
            curl_setopt($this->r_curl, CURLOPT_HEADER, FALSE);
            //2.信息已文件流形式返回，而不是直接输出
            curl_setopt($this->r_curl, CURLOPT_RETURNTRANSFER, TRUE);
        }

        /**
         * 发送curl请求
         * @return mixed
         */
        abstract function sendRequest();

        /**
         * 构造方法首先执行的方法
         */
        public function __init() {
        }

        /**
         * SSL验证证书
         */
        private function verifySSL() {
            if ($this->b_SSL === TRUE):
                curl_setopt($this->r_curl, CURLOPT_SSL_VERIFYPEER, TRUE);
                curl_setopt($this->r_curl, CURLOPT_SSL_VERIFYHOST, 2);//严格校验
                curl_setopt($this->r_curl, CURLOPT_SSLCERTTYPE, $this->s_SSL_CERT_TYPE);
                curl_setopt($this->r_curl, CURLOPT_SSLCERT, $this->s_SSL_CERT);
                curl_setopt($this->r_curl, CURLOPT_SSLKEYTYPE, $this->s_SSL_KEY_TYPE);
                curl_setopt($this->r_curl, CURLOPT_SSLKEY, $this->s_SSL_KEY);
            else:
                curl_setopt($this->r_curl, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($this->r_curl, CURLOPT_SSL_VERIFYHOST, FALSE);//严格校验
            endif;
        }


        /**
         * 设置证书、私钥的类型已经文件路径
         *
         * @param bool $b_isSet
         * @param      $a_SSL
         */
        public function setSSL($b_isSet = FALSE, array $a_SSL = []) {
            if ($b_isSet === TRUE):
                $this->b_SSL = TRUE;
                $this->s_SSL_CERT_TYPE = $a_SSL['SSL_CERT_TYPE'] || 'PEM';
                $this->s_SSL_CERT = $a_SSL['SSL_CERT'];
                $this->s_SSL_KEY_TYPE = $a_SSL['SSL_KEY_TYPE'] || 'PEM';
                $this->s_SSL_KEY = $a_SSL['SSL_KEY'];
            else:
                $this->b_SSL = FALSE;
            endif;
            $this->verifySSL();
        }

        /**
         * 析构函数
         */
        public function __destruct() {
            //1.释放curl资源
            curl_close($this->r_curl);
        }
    }