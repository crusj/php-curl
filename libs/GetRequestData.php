<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 9:09
     */

    namespace curl\libs;

    /**
     * CURL GET 方式请求数据格式类
     * Class GetInputData
     * @package curl\libs
     */
    class GetRequestData extends RequestData
    {
        /**
         * 返回GET请求方式串
         * @return string
         */
        public function createData() {
            if (!empty($this->a_data) || is_array($this->a_data)):
                $a_data = $this->a_data;
                //1.按字段名排序
                ksort($a_data);
                //2.生成GET请求参数
                $s_data = '';
                foreach ($a_data as $s_key => $m_value):
                    $s_data .= $s_key.'='.$m_value.'&';
                endforeach;
                return  rtrim($s_data,'&');

            else:
                return '';
            endif;
        }
    }
