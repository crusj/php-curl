<?php

//curl get测试

//require autoloader

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once "./psr4AutoLoader.php";

if ($_SERVER["CONTENT_TYPE"] === "application/xml") {
    echo "The xml data is:";
    echo "<pre>";
    echo file_get_contents("php://input");
    echo "</pre>";
} else {
    $autoLoader = new Psr4AutoLoader();
    $autoLoader->register();
    $requestComposer = new \curl\libs\CurlComposer("http://172.17.0.4/test/xml.php", "XML", ['isAcceptRequest' => 1]);
    $result = $requestComposer->sendRequest();
    if ($result === false) {
        echo "error! ";
        echo $requestComposer->getErrorMsg();
    } else {
        echo "ok !";
        echo $result;
    }
}


