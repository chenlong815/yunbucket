<?php
require '../qiniuyun/mysql.php';

if(empty($_GET['url'])||empty($_GET['key'])){
    echo "没有提供任何参数！";
    return false;
}
$url=$_GET['url'];
$file_name=$_GET['key'];

echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>海贝数据创新共享平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>

   <!--  <link rel="stylesheet" href="assets/css/style.css"> -->
    <link rel="stylesheet" href="assets/css/loader-style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/signin.css">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/minus.png">
</head>

<body> 
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    
    <div class="container">
        <div class="" id="login-wrapper">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div id="logo-login">
                        <h1>海贝数据下载

                        </h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="account-box"> 
                        <form role="form" method="post" action="http://123.57.242.185/yunbucket/qiniuyun/downLoadAction.php">
                            <div class="form-group">
                                <!--a href="#" class="pull-right label-forgot">Forgot password?</a-->
                                <label for="inputPassword">提取密码</label>
                                <input type="password" id="npass" name="npass" class="form-control">
                                <input type="hidden" id="purl" name="url" value="'.$url.'">
                                <input type="hidden" id="pkey" name="key" value="'.$file_name.'">
                            </div>
                            <button class="btn btn btn-primary pull-right" type="submit">
                                提 取
                            </button>
                        </form>
                        <a class="forgotLnk" href="#"></a>

                        <div class="row-block">
	                        <div class="row">
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 		<p>&nbsp;</p>
        <div style="text-align:center;margin:0 auto;">
            <h6 style="color:#fff;">海贝数据创新共享平台 | <a href="mailto:seashelldata@seashelldata.org">联系我们</a>
<br />
				</h6>
        </div>
    </div>
</body>

</html>';
?>
<!--<a href="mailto:sample@163.com?subject=test&cc=sample@hotmail.com&body=use mailto sample">send mail</a>-->

