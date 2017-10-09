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
            curl_setopt($this->r_curl, CURLOPT_URL, $this->s_requestUrl);
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
