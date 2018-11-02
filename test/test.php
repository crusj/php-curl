<?php
    /**
     * Created by PhpStorm.
     * User: lance
     * Date: 2017/9/7
     * Time: 13:31
     */

    namespace curl\libs;
    require_once '../../AutoLoad.class.php';
    \AutoLoad::registerAutoLoad();
    //1.测试test请求
    $o_curl = new CurlComposer('http://127.0.0.1/index.php', 'get');
    if (($m_rsl = $o_curl->sendRequest()) === FALSE):
        var_dump($o_curl->getErrorMsg());
    else:
        var_dump($m_rsl);
    endif;
    echo '<hr>';
    //2.测试POST请求
    $o_curl = new CurlComposer('http://127.0.0.1/testRequest/post.php', 'post',[
        'singer' => '王菲',
        'song' => '匆匆那年'
    ]);
    if (($m_rsl = $o_curl->sendRequest()) === FALSE):
        var_dump($o_curl->getErrorMsg());
    else:
        var_dump(json_decode($m_rsl,true));
    endif;
    echo '<hr>';
    //3.测试JSON请求
    $o_curl = new CurlComposer('http://127.0.0.1/testRequest/json.php', 'json',[
        'singer' => '王菲',
        'song' => '匆匆那年'
    ]);
    if (($m_rsl = $o_curl->sendRequest()) === FALSE):
        var_dump($o_curl->getErrorMsg());
    else:
        echo '<pre>';
        var_dump(json_decode($m_rsl,true));
        echo '<pre>';
    endif;
    echo '<hr>';
    //4.测试XML请求
    $o_curl = new CurlComposer('http://127.0.0.1/testRequest/xml.php', 'xml',[
        'singer' => '王菲',
        'song' => '匆匆那年'
    ]);
    if (($m_rsl = $o_curl->sendRequest()) === FALSE):
        var_dump($o_curl->getErrorMsg());
    else:
        echo '<pre>';
        var_dump($m_rsl);
        echo '</pre>';
    endif;
