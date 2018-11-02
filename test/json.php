<?php

//curl get测试

//require autoloader

ini_set('display_errors','On');
error_reporting(E_ALL);
require_once "./psr4AutoLoader.php";

if ($_SERVER["CONTENT_TYPE"] === "application/json") {
    echo "The json params is:".file_get_contents("php://input");
} else {
    $autoLoader = new Psr4AutoLoader();
    $autoLoader->register();
    $requestComposer = new \curl\libs\CurlComposer("http://127.0.0.1/test/json.php", "JSON", ['isAcceptRequest' => 1]);
    $result = $requestComposer->sendRequest();
    if ($result === false) {
        echo "error! ";
        $requestComposer->getErrorMsg();
    } else {
        echo "ok !";
        echo $result;
    }
}


