<?php
/**
 * author crusj
 * date   2019/12/18 10:45 上午
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once "./psr4AutoLoader.php";

if (isset($_GET['isAcceptRequest']) && $_GET['isAcceptRequest'] == 1) {
    echo "the get Params is:" . json_encode($_GET);
} else {
    $autoLoader = new Psr4AutoLoader();
    $autoLoader->register();
    $requestComposer = new \curl\libs\CurlComposer("http://127.0.0.1:8080/token", "GET",
        [
            'count' => 5
        ],
        [],
        [
            'Authorization' => base64_encode(sprintf("%s:%s", '2c05bdc818945cb80dbc79ce', '97811ea93f13624cc15f754f'))
        ]);
    $result = $requestComposer->sendRequest();
    if ($result === false) {
        echo "error! ";
        var_dump($requestComposer->getErrorMsg());
    } else {
        echo "ok !";
        var_dump($result);
    }
}
