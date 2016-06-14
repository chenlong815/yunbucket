
<html>
<head>
    <title>List文件</title>
    <meta charset="utf-8">
</head>
<body>
<h1>List文件测试</h1>
<div>
<?php

require_once '..\phpsdk706\autoload.php';

// 引入鉴权类
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

// 引入上传类

//调用获取Bucket文件List方法
GetList();

function GetList(){
     $prefix = '';
     $marker = '';
     $limit = 10;//限制获取多少条

     $result=ListFile($prefix,$marker,$limit);
     var_dump($result);

     for($i=0;$i<count($result);$i++){

   echo $result[$i]['key'].'</br>';
//         var_dump($result[$i]);
         echo '</br>';

        echo '<a href="urlGet.php?item1='.$result[$i]['key'].
            '" id="it1" name="item1">'.$result[$i]['key'].'</a></br>';
         echo '<a href="urlGet.php?item1='.$result[$i]['key'].
             '" id="it1" name="item1">'.$result[$i]['key'].'</a></br>';
     }
}

function ListFile($prefix,$marker,$limit){

    $accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
    $secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';
    $bucket = 'testupload';//指定Bucket

    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);

    list($iterms,$marker,$err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
    if ($err !== null) {
        echo "\n====> list file err: \n";
        var_dump($err);
    } else {
        var_dump($iterms);

        return $iterms;
    }
}

?>
</div>

</body>
</html>