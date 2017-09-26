<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 9:03
     */

    namespace curl\libs;

    /**
     * 请求数据对象
     * Class InputData
     * @package curl\libs
     */
    abstract class RequestData
    {
        protected $a_data = [];//请求数据
        public function __construct($a_data) {
            $this->a_data = $a_data;
        }

        /**
         * 根据输入对象类型不同创建不同的数据格式
         * @return mixed
         */
        abstract function createData();
    }