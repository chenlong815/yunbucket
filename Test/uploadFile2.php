<html>
<head>
    <title>云存储</title>
    <meta charset="utf-8">
    <link href="../css/indexstyle.css" type="text/css" rel="stylesheet">
    <script src="../js/Ajax.js"></script>

</head>
<body>

<div id="up_load">

<div id="title">
    <h1 align="center">NPO云存储</h1>

</div>

<!--    <button onclick="window.location.href='urlGet.php'">点我</button>-->

<?php
require '../phpsdk706/autoload.php';

// 引入鉴权类
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

// 引入上传类

$accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
$secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';

$bucket = 'testupload';

//鉴权
$auth = new Auth($accessKey, $secretKey);

// 生成上传 Token
//$token = $auth->uploadToken($bucket);

$policy = array(
    'saveKey' => '$(fname)',
    "returnUrl"=>'http://localhost/yunbucket/qiniuyun/index.php'
);
$token = $auth->uploadToken($bucket,null,3600,$policy);
//echo $token;

function GetList($accessKey,$secretKey,$bucket){
    $prefix = '';
    $marker = '';
    $limit = 10;//限制获取多少条

    $result=ListFile($accessKey,$secretKey,$prefix,$marker,$limit);
//     var_dump($result);
//    echo '<button id='.'sharetest'.' onclick='."testScript"."('点击成功')".">测试</button>";

    for($i=0;$i<count($result);$i++){
//   echo $result[$i]['key'].'</br>';
        echo '<div id="listitem">
            <a id="list_a" href="#">'.$result[$i]['key'].'</a>
            <button id="share" onclick="'."window.location.href="."'urlGet.php?item1=".$result[$i]['key']."'".'">分享</button>

            </div>';
//        <a id="list_a" href="urlGet.php?item1='.$result[$i]['key'].'" id="it1" name="item1">'.$result[$i]['key'].'</a>
//        <button id="delete" onclick="'.DeleteFile($accessKey,$secretKey,$bucket,$result[$i]['key']).'">删除</button>
    }
}

function urlGet($accessKey,$secretKey,$key,$ifsecret){

    $domain='7xp8g8.com1.z0.glb.clouddn.com';
//初始化Auth状态：
    $auth = new Auth($accessKey, $secretKey);
// 私有空间中的外链 http://<domain>/<file_key>
    $baseUrl = 'http://'.$domain.'/'.$key;

// 对链接进行签名
    $signedUrl = $auth->privateDownloadUrl($baseUrl);
//echo $signedUrl;

    if($ifsecret==0){
        $url=$baseUrl;
    }else{
        $url=$signedUrl;
    }
}

function ListFile($accessKey,$secretKey,$prefix,$marker,$limit){
//    $accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
//    $secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';
    $bucket = 'testupload';//指定Bucket

    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);

    list($iterms,$marker,$err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
    if ($err !== null) {
        echo "\n====> list file err: \n";
        var_dump($err);
    } else {
        return $iterms;
    }
}

function DeleteFile($accessKey,$secretKey,$bucket, $key){
    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);
    $result=$bucketMgr->delete($bucket, $key);

}

echo '
<div id="upfile">
<form id="upfile_form" method="post" action="http://upload.qiniu.com/"
          enctype="multipart/form-data">
        <input name="token" type="hidden" value="'.$token.'"/>
        <input name="x:price" type="hidden" value="1500.00">
        <input name="file" id="file" type="file" />
        <input type="submit" id="uploadsubmit" value="提交"/>
    </form>
</div>';

echo '<div id="list_file"><ul id="listul">
            <li id="li_name">文件名</li>

            <li id="li_deal">操作</li>
            <li id="li_time">上传时间</li>
            <li id="li_size">大小</li>

      </ul>
';

GetList($accessKey,$secretKey,$bucket);
echo '</div>';

echo '<div id="pagediv"><ul id="pageul">';
        for($j=0;$j<10;$j++){
            echo '<a id="pageitem" href="#">'.$j.'</a>';
        }
        echo '<a id="pageitem" href="#">上一页</a>
        <a id="pageitem" href="#">下一页</a>
        <a id="pageitem" href="#">首页</a>
        <a id="pageitem" href="#">尾页</a>

        <input id="page_jump" type="button" name="page_jump" value="跳转">
        <input id="page_edit" type="text" name="page_edit">
        ';
echo '</ul></div>';

?>
</div>
