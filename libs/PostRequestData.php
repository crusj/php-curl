<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 11:53
     */

    namespace curl\libs;


    class PostRequestData extends RequestData
    {
        public function createData() {

            ksort($this->a_data);
            return $this->a_data;
        }
    }