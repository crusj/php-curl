# php curl

send http request,request method includes get post,request content-type includes application/json,application/xml

##  file structure

├── composer.json<br/>
├── composer.lock<br/>
├── libs <br/>
│   ├── CurlComposer.php<br/>
│   ├── Curl.php<br/>
│   ├── GetCurl.php<br/>
│   ├── GetRequestData.php<br/>
│   ├── JsonCurl.php<br/>
│   ├── JsonRequestData.php<br/>
│   ├── PostCurl.php<br/>
│   ├── PostRequestData.php<br/>
│   ├── RequestData.php<br/>
│   ├── XmlCurl.php<br/>
│   └── XmlRequestData.php<br/>
├── README.md<br/>
├── test  <br/>
│   ├── get.php<br/>
│   ├── psr4AutoLoader.php //自动加载,用于测试以及飞composer安装<br/>
│   └── test.php<br/>
└── UML.png<br/>

## examples

### send GET request

```php
$requestUri = "http://127.0.0.1/test/get.php";
$requestMethod = "GET";
$params = [
    "p1" => 1,
    "p2" => 2
];
$requestComposer = new \curl\libs\CurlComposer($requestUri, $requestMethod, $params);

//requestUrl  http://127.0.0.1/test/get.php?p1=1&p2=2
$result = $requestComposer->sendRequest();
// bad request
if(result === false){
    echo $requestComposer->getErrorMsg();
}else{
    ...
}
```
### send POST request

the only different is $requestMethod to "POST"

```php
$requestUri = "http://127.0.0.1/test/post.php";
$requestMethod = "POST";
$params = [
    "p1" => 1,
    "p2" => 2
];
$requestComposer = new \curl\libs\CurlComposer($requestUri, $requestMethod, $params);

//requestUrl  http://127.0.0.1/test/post.php
$result = $requestComposer->sendRequest();
// bad request
if(result === false){
    echo $requestComposer->getErrorMsg();
}else{
    ...
}
```

### send JSON request

the only different is $requestMethod to "JSON"

```php
$requestUri = "http://127.0.0.1/test/json.php";
$requestMethod = "JSON";
$params = [
    "p1" => 1,
    "p2" => 2
];
$requestComposer = new \curl\libs\CurlComposer($requestUri, $requestMethod, $params);

//requestUrl  http://127.0.0.1/test/json.php
$result = $requestComposer->sendRequest();
// bad request
if(result === false){
    echo $requestComposer->getErrorMsg();
}else{
    ...
}
```
### send XML request

the only different is $requestMethod to "XML"

```php
$requestUri = "http://127.0.0.1/test/xml.php";
$requestMethod = "XML";
$params = [
    "p1" => 1,
    "p2" => 2
];
$requestComposer = new \curl\libs\CurlComposer($requestUri, $requestMethod, $params);

//requestUrl  http://127.0.0.1/test/xml.php
$result = $requestComposer->sendRequest();
// bad request
if(result === false){
    echo $requestComposer->getErrorMsg();
}else{
    ...
}
```

## log

### v1.0.0
* 基本的get,post,json,xml请求发送、支持SSL
* 请求发送成功返回body，如果是response头为attachment则会返回附件的临时本地地址，
* 请求失败返回false,通过`getErrorMsg`方法获取错误信息
* 问题：只把响应头为200的请求判定为成功，基于restful风格的则会出现问题

### v1.1.0
* 发送请求时支持设置请求头，newCurlComposer($uri,$method,$param,$ssl,array $header),请求头的格式为键值对,或者冒号分割的形式
* 返回数据现在会返回一个包含code与body的数组,不限于响应头为200





