<?php

//curl get测试

//require autoloader

ini_set('display_errors','On');
error_reporting(E_ALL);
require_once "./psr4AutoLoader.php";

if (isset($_GET['isAcceptRequest']) && $_GET['isAcceptRequest'] == 1) {
    echo "the get Params is:".json_encode($_GET);
} else {
    $autoLoader = new Psr4AutoLoader();
    $autoLoader->register();
    $requestComposer = new \curl\libs\CurlComposer("http://127.0.0.1/test/get.php", "GET", ['isAcceptRequest' => 1]);
    $result = $requestComposer->sendRequest();
    if ($result === false) {
        echo "error! ";
        $requestComposer->getErrorMsg();
    } else {
        echo "ok !";
        echo $result;
    }
}


