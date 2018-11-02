## php curl

send http request,request method includes get post,request content-type includes application/json,application/xml

###  file structure

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

### examples

#### send GET request

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
#### send POST request

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

#### send JSON request

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
#### send XML request

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





