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