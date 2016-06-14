<html>
<head>
    <title>基于云存储的NPO数据共享平台</title>
    <meta charset="utf-8">
    <link href="css/indexstyle.css" type="text/css" rel="stylesheet">
</head>
<body>

<div id="up_load">

<div id="title">
    <h1 align="center">基于云存储的NPO数据共享平台</h1>
</div>

<?php

if(!isset($_GET['page'])){
    $page=1;
}else{
    $page=$_GET['page'];
}

require BASEPATH . '/phpsdk706/autoload.php';//引入七牛SDK

// 引入鉴权类
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

// 引入上传类

$accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
$secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';
//鉴权
$auth = new Auth($accessKey, $secretKey);

$bucket = 'testupload';

// 生成上传 Token
$policy = array(
    'saveKey' => '$(fname)'
    ,"returnUrl"=>'http://123.57.242.185/yunbucket/qiniuyun/Suc_uploadSuccess.html'
);
$token = $auth->uploadToken($bucket,null,3600,$policy);

//得到文件列表
$prefix = '';
$marker = '';
$limit = 1000;//限制获取多少条

$result=ListFile($accessKey,$secretKey,$prefix,$marker,$limit,$bucket);

$allcount=count($result);//得到总条数
$pagelimit=20;//每页显示多少行
$pagelen=ceil($allcount/$pagelimit);
//echo $pagelen;

if($page<1){
    $page=1;
}
if($page>$pagelen){
    $page=$pagelen;
}

function DealPage($result,$pagelimit,$page,$allcount){
    $begin=($page-1)*$pagelimit;
    $end=$page*$pagelimit;
    if($end>$allcount){
        $end=$allcount;
    }
    for($i=$begin;$i<$end;$i++){
        echo '
        <tr id="listitem">
            <td id="td_time">'.GetTime($result[$i]['putTime']).'</td>
            <td id="td_name">'.$result[$i]['key'].'</td>
            <td id="td_size">'.GetSize($result[$i]['fsize']).'</td>
            <td id="td_deal"><button id="share" onclick="'."window.location.href='"."urlGet.php?item1=".$result[$i]['key']."'".'">分享</button><td>
            </tr>';
    }
}

function GetTime($tim){
    $da=substr($tim,0,11);
    $ttime=findNum($da);
//    return $ttime;
    return date("Y-m-d H:i:s",$ttime);
}

function findNum($str=''){
    $str=trim($str);
    if(empty($str)){return '';}
    $temp=array('1','2','3','4','5','6','7','8','9','0');
    $result='';
    for($i=0;$i<strlen($str);$i++){
        if(in_array($str[$i],$temp)){
            $result.=$str[$i];
        }
    }
    return $result;
}


function GetSize($initsize){
    $changesize='';
    if($initsize<1024){
        $changesize='1 KB';
    }
    if(1024<$initsize&&$initsize<1024000){
        $changesize=(String)round($initsize/1024,0).' KB';

    }elseif(1024000<$initsize&&$initsize<1024000000){
        $changesize=(String)round($initsize/1024000,2).' MB';

    }elseif(1024000000<$initsize){
        $changesize=(String)round($initsize/1024000000,4).' GB';
    }
    return $changesize;
}

function urlGet($accessKey,$secretKey,$key,$ifsecret){
//七牛子域名是一个创建空间时缺省分配的域名，开发者可以在开发者平台 - 空间设置 - 域名设置查看该子域名
    $domain='7xp8g8.com1.z0.glb.clouddn.com';
//初始化Auth状态：
    $auth = new Auth($accessKey, $secretKey);
// 私有空间中的外链 http://<domain>/<file_key>
    $baseUrl = 'http://'.$domain.'/'.$key;

// 对链接进行签名
    $signedUrl = $auth->privateDownloadUrl($baseUrl);

    if($ifsecret==0){
        $url=$baseUrl;
    }else{
        $url=$signedUrl;
    }
}

function ListFile($accessKey,$secretKey,$prefix,$marker,$limit,$bucket){
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
<form id="upfile_form" method="POST" action="http://upload.qiniu.com/"
          enctype="multipart/form-data">
        <input name="token" type="hidden" value="'.$token.'"/>
        <input name="x:price" type="hidden" value="1500.00">
        <input name="file" id="file" type="file" />
        <input type="submit" id="uploadsubmit" value="确认上传"/>
    </form>
</div>';

echo '<div id="list_file">
<table id="listtable">
                <tr>
                  <th id="th_time">上传时间</th>
                  <th id="th_name">文件名</th>
                  <th id="th_size">大小</th>
                  <th id="th_deal">操作</th>
                </tr>
';

DealPage($result,$pagelimit,$page,$allcount);

echo '</table></div>';

echo '<div id="pagediv"><ul id="pageul">';
        if($pagelen<4&&$page<4){

            for($j=1;$j<=$pagelen;$j++){
                echo '<a id="pageitem" href="index.php?page='.$j.'">'.$j.'</a>';
            }
        }
        if($pagelen>4&&$page<4){
            for($j=1;$j<=4;$j++){
                echo '<a id="pageitem" href="index.php?page='.$j.'">'.$j.'</a>';
            }
            echo '<a id="pageitem" href="#">...</a>';
            echo '<a id="pageitem" href="index.php?page='.$pagelen.'">'.$pagelen.'</a>';
        }
        if($pagelen>=4&&$page>=4&&$page<=$pagelen-4){
            echo '
            <a id="pageitem" href="index.php?page=1">1</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" href="index.php?page='.($page-2).'">'.($page-2).'</a>
            <a id="pageitem" href="index.php?page='.($page-1).'">'.($page-1).'</a>
            <a id="pageitem" href="index.php?page='.$page.'">'.$page.'</a>
            <a id="pageitem" href="index.php?page='.($page+1).'">'.($page+1).'</a>
            <a id="pageitem" href="index.php?page='.($page+2).'">'.($page+2).'</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" href="index.php?page='.$pagelen.'">'.$pagelen.'</a>
            ';
        }
        if($pagelen>4&&$page>($pagelen-4)){
            echo '
            <a id="pageitem" href="index.php?page=1">1</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" href="index.php?page='.($pagelen-4).'">'.($pagelen-4).'</a>
            <a id="pageitem" href="index.php?page='.($pagelen-3).'">'.($pagelen-3).'</a>
            <a id="pageitem" href="index.php?page='.($pagelen-2).'">'.($pagelen-2).'</a>
            <a id="pageitem" href="index.php?page='.($pagelen-1).'">'.($pagelen-1).'</a>
            <a id="pageitem" href="index.php?page='.$pagelen.'">'.$pagelen.'</a>
            ';
        }

        echo '<a id="pageitem2" href="index.php?page='.pgDeal($page-1,$pagelen).'">上一页</a>
        <a id="pageitem" href="index.php?page='.pgDeal($page+1,$pagelen).'">下一页</a>
        <a id="pageitem" href="index.php?page=1">首页</a>
        <a id="pageitem" href="index.php?page='.$pagelen.'">尾页</a>

        <form id="pagejump_form" method="get" action="index.php?"
          >
            <input id="page_edit" type="text" name="page">
            <input id="page_jump" type="submit" name="page_jump" value="跳转">
        </form>

        <a id="tool" href="https://github.com/qiniu/qsunsync">云上传工具下载</a>
        ';
echo '</ul></div>';

function pgDeal($page,$pagelentg){
    if($page>$pagelentg){
        return $pagelentg;
    }elseif($page<1){
        return 1;
    }else{
        return $page;
    }
}
?>
</div>