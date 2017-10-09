<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 10:56
     */

    namespace curl\libs;

    /**
     * 发送一个POST请求，数据类型为JSON
     * Class CurlJson
     * @package curl\libs
     */
    class JsonCurl extends Curl
    {
        public function sendRequest() {
            //请求的数据
            $s_data = $this->o_requestData->createData();
            //1.设置请求地址
            curl_setopt($this->r_curl, CURLOPT_URL, $this->s_requestUrl);
            //2.设置请求类型
            curl_setopt($this->r_curl, CURLOPT_POST, TRUE);
            //3.设置请求头
            curl_setopt($this->r_curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($s_data),
            ]);
            curl_setopt($this->r_curl, CURLOPT_HEADER, TRUE);
            curl_setopt($this->r_curl, CURLOPT_NOBODY, FALSE);
            curl_setopt($this->r_curl, CURLOPT_RETURNTRANSFER, TRUE);

            //4.设置请求数据
            curl_setopt($this->r_curl, CURLOPT_POSTFIELDS, $s_data);
            $rsl = curl_exec($this->r_curl);
            try {
                //状态值不为200
                $s_httpCode = curl_getinfo($this->r_curl, CURLINFO_HTTP_CODE);
                if ($s_httpCode != '200'):
                    throw new \Exception(curl_error($this->r_curl));
                endif;
                $a_res = $this->sepHeaderBody($rsl);
                //如果为附件
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
            } catch (\Exception $e) {
                $this->s_errorMsg = $e->getMessage();

                return FALSE;
            }
        }
    }