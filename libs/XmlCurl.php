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
            curl_setopt($this->r_curl, CURLOPT_HEADER, TRUE);
            curl_setopt($this->r_curl, CURLOPT_NOBODY, FALSE);
            $s_rsl = curl_exec($this->r_curl);
            try{
                //判断状态
                if (curl_getinfo($this->r_curl, CURLINFO_HTTP_CODE) == '200'):
                    $a_res = $this->sepHeaderBody($s_rsl);
                    //附件
                    if ($a_res['attachment'] !== FALSE):
                        $s_path = dirname(__DIR__);
                        $s_fileName = $s_path . '/tmp/' . $a_res['attachment'];
                        if (($s_filePath = $this->saveTmpFile($s_fileName, $a_res['body'])) === FALSE):
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
    }