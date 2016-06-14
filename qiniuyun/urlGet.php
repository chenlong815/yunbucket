<html>
<head>
    <title>邮件发送</title>
    <meta charset="utf-8">

    <link href="../css/emailstyle.css" type="text/css" rel="stylesheet">

</head>
<body>

<?php
require '../phpsdk706/autoload.php';

use Qiniu\Auth;

$key = $_GET['item1']; //文件名

//调用生成Url方法
$ur = GetDownLoadUrl($key, 0);

function GetDownLoadUrl($key, $ifsecret)
{
    $accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
    $secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';
    $domain = '7xp8g8.com1.z0.glb.clouddn.com';
//初始化Auth状态：
    $auth = new Auth($accessKey, $secretKey);
// 私有空间中的外链 http://<domain>/<file_key>
    $baseUrl = 'http://' . $domain . '/' . $key;

// 对链接进行签名
    $signedUrl = $auth->privateDownloadUrl($baseUrl);
//echo $signedUrl;

    if ($ifsecret == 0) {
        $url = $baseUrl;
    } else {
        $url = $signedUrl;
    }

    return $url;
}

echo '
<div id="emailmain">
    <div id="titlediv" >
        <h2 id="titledivh2" align="center">邮件发送</h2>
    </div>
    <div id="formdiv" >
        <form id="sendemail" method="post" action="toEmail.php"
          enctype="multipart/form-data">

        <h4 id="hr">收件人:</h4>
        <input name="receiver" id="receiver" type="text"/>
        <h4 id="hs">主    题:</h4>
        <input name="subject" id="subject" type="text"/>
        <h4 id="hc">内    容:</h4>
        <textarea name="content" id="content"></textarea>
        <input name="downurl" type="hidden" value="' . $ur . '"/>
        <input name="key" type="hidden" value="' . $key . '"/>
        <input type="submit" name="sub" id="sub" value="确定发送">
    </form>
    </div>

</div>
';
?>

</body>
</html>
