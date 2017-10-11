<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/6
     * Time: 22:20
     */

    namespace curl\libs;

    use File\libs\action\FileCreate;

    abstract class Curl
    {
        protected $s_errorMsg;//错误信息
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
        protected function sendRequest(){
            $s_rsl = curl_exec($this->r_curl);
            try{
                //判断状态
                if (curl_getinfo($this->r_curl, CURLINFO_HTTP_CODE) == '200'):
                    $a_res = $this->sepHeaderBody($s_rsl);
                    //附件
                    if ($a_res['attachment'] !== FALSE):
                        $s_path = dirname(__DIR__);
                        $s_fileName = $s_path . '/tmp/' . $a_res['attachment'];
                        if (($s_filePath = $this->saveTmpFile((string)$s_fileName, $a_res['body'])) === FALSE):
                            throw new \Exception($this->getErrorMsg());
                        else:
                            return  $s_filePath;
                        endif;
                    else:
                        return $a_res['body'];
                    endif;
                else:
                    throw new \Exception(curl_error($this->r_curl));
                endif;
            }catch (\Exception $e){
                $this->s_errorMsg = $e->getMessage();
                return false;
            }
        }

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
         * 设置CURL opts
         * @param array $extraOpts 额外的opt
         */
        public function setOpts(array $extraOpts = []) {
            $a_opts = [
                CURLOPT_URL=> $this->s_requestUrl,
                CURLOPT_HEADER=> TRUE,//头文件作为输出流
                CURLOPT_NOBODY=> FALSE,//是否显示html body
                CURLOPT_AUTOREFERER=> TRUE,//重定向的时候带上referrer
                CURLOPT_FOLLOWLOCATION=> TRUE,//允许重定向
                CURLOPT_RETURNTRANSFER=> TRUE,
            ];
            //合并Options
            $a_opts += $extraOpts;
            curl_setopt_array($this->r_curl,$a_opts);
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

        /**
         * 返回错误信息
         * @return mixed
         */
        public function getErrorMsg() {
            return $this->s_errorMsg;
        }

        /**
         * 分离响应信息信息
         *
         * @param $s_response
         *
         * @return array
         */
        public function sepHeaderBody($s_response) {
            $i_headerLen = curl_getinfo($this->r_curl, CURLINFO_HEADER_SIZE);
            //响应头
            $s_header = substr($s_response, 0, $i_headerLen);
            //判断是否是附件
            if (strstr($s_header, 'attachment') !== FALSE):
                //获取附件名
                preg_match('/filename=(.*?)\r\n/', $s_header, $a_match);
                $m_attachmentName = trim($a_match[1], '\"');
            else:
                $m_attachmentName = FALSE;
            endif;
            //响应体
            $s_body = substr($s_response, $i_headerLen);

            return [
                'body'       => $s_body,
                'attachment' => $m_attachmentName,
            ];
        }

        /**
         * 保存临时文件，成功返回文件名，失败返回false
         *
         * @param $s_fileName
         * @param $s_body
         *
         * @return bool|string
         */
        public function saveTmpFile($s_fileName, $s_body) {
            $o_createFile = new FileCreate($s_fileName);
            if ($o_createFile->operate($s_body, FALSE) === FALSE):
                $this->s_errorMsg = $o_createFile->getLastError();

                return FALSE;
            endif;

            return $o_createFile->getFullName();

        }
    }