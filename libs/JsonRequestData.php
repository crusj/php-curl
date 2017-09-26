<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 11:54
     */

    namespace curl\libs;

    /**
     * json格式数据
     * Class JsonRequestData
     * @package curl\libs
     */
    class JsonRequestData extends RequestData
    {
        public function createData() {
            ksort($this->a_data);

            return json_encode((Array)$this->a_data,JSON_UNESCAPED_UNICODE);
        }
    }
