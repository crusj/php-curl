<?php

//curl get测试

//require autoloader

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once "./psr4AutoLoader.php";

if (isset($_POST['isAcceptRequest']) && $_POST['isAcceptRequest'] == 1) {
    echo "The post params is:" . json_encode($_POST);
} else {
    $autoLoader = new Psr4AutoLoader();
    $autoLoader->register();
    $requestComposer = new \curl\libs\CurlComposer("http://127.0.0.1/test/post.php", "POST", ['isAcceptRequest' => 1]);
    $result = $requestComposer->sendRequest();
    if ($result === false) {
        echo "error! ";
        $requestComposer->getErrorMsg();
    } else {
        echo "ok !";
        echo $result;
    }
}


