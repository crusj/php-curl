<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 11:56
     */

    namespace curl\libs;

    /**
     * xml格式数据
     * Class XmlRequestData
     * @package curl\libs
     */
    class XmlRequestData extends RequestData
    {
        public function createData() {
            ksort($this->a_data);
            var_dump($this->a_data);
            if (!is_array($this->a_data) || count($this->a_data) <= 0) {
                return '';
            }

            $s_xml = "<xml>";
            foreach ($this->a_data as $key => $val) {
                //支持二级嵌套
                if (is_array($val)):
                    $s_xml .= "<".$key.">";
                    foreach ($val as $k => $v):
                        if (is_numeric($v)) {
                            $s_xml .= "<" . $k . ">" . $v . "</" . $k . ">";
                        } else {
                            $s_xml .= "<" . $k . "><![CDATA[" . $v . "]]></" . $k . ">";
                        }
                    endforeach;
                    $s_xml .= "</".$key.">";
                else:
                    if (is_numeric($val)) {
                        $s_xml .= "<" . $key . ">" . $val . "</" . $key . ">";
                    } else {
                        $s_xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
                    }
                endif;
            }
            $s_xml .= "</xml>";

            return $s_xml;
        }
    }