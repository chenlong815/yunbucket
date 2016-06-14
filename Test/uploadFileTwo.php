<html>
<head>
    <title>Uploading...</title>
    <meta charset="utf-8">

</head>
<body>
<h1>Uploading file...</h1>

<div>
    <?php

    require '../phpsdk706/autoload.php';

    // 引入鉴权类
    use Qiniu\Auth;

    // 引入上传类

    $accessKey = 'IctPS27e8I9j0tg0Drg7WwEsACn-sjwk5NxQQ2HN';
    $secretKey = 'gb-kAwYTalmC0Lrdpj3dHxp1qDbNwrZvAifQUoJf';
    $bucket = 'testupload';

    //鉴权
    $auth = new Auth($accessKey, $secretKey);

    // 生成上传 Token
    //$token = $auth->uploadToken($bucket);

    $policy = array(
        'saveKey' => '$(fname)'
    );
    $token = $auth->uploadToken($bucket, null, 3600, $policy);

    //echo $token;

    echo '<form method="post" action="http://upload.qiniu.com/"
          enctype="multipart/form-data">
        <input name="token" type="hidden" value="' . $token . '"/>
        <input name="file" id="file" type="file" />

        <input type="submit" value="提交"/>
    </form>';

    ?>

</div>
