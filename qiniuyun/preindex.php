<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>基于云存储的NPO数据共享平台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <script type="text/javascript" src="assets/js/jquery.js"></script>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/loader-style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/js/button/ladda/ladda.min.css">

    <link rel="stylesheet" href="assets/css/indexstyle2.css" type="text/css">
    <link rel="stylesheet" href="../bootstrap-3.3.5-dist/css/bootstrap.css">

    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/minus.png">
</head>

<body>

<?php
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

require '../phpsdk706/autoload.php'; //引入七牛SDK

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
, "returnUrl" => 'http://123.57.242.185/yunbucket/qiniuyun/Suc_uploadSuccess.html'
);
$token = $auth->uploadToken($bucket, null, 3600, $policy);

//得到文件列表
$prefix = '';
$marker = '';
$limit = 1000; //限制获取多少条

$result = ListFile($accessKey, $secretKey, $prefix, $marker, $limit, $bucket);

$allcount = count($result); //得到总条数
$pagelimit = 20; //每页显示多少行
$pagelen = ceil($allcount / $pagelimit);
//echo $pagelen;

if ($page < 1) {
    $page = 1;
}
if ($page > $pagelen) {
    $page = $pagelen;
}

function DealPage($result, $pagelimit, $page, $allcount)
{
    $begin = ($page - 1) * $pagelimit;
    $end = $page * $pagelimit;
    if ($end > $allcount) {
        $end = $allcount;
    }
    for ($i = $begin; $i < $end; $i++) {
        echo '
        <tr id="listitem">
            <td id="td_time">' . ($i + 1) . '</td>
            <td id="td_time">' . GetTime($result[$i]['putTime']) . '</td>
            <td id="td_name">' . $result[$i]['key'] . '</td>
            <td id="td_size">' . GetSize($result[$i]['fsize']) . '</td>
            <td id="td_twice">' . ($i + 1) . '</td>
            <td id="td_deal"><a id="share" class="btn btn-primary btn-lg active" role="button" href="' . 'prEmail.php?item1=' . $result[$i]['key'] . '">分享</a><td>
            </tr>';
    }
}

function GetTime($tim)
{
    $da = substr($tim, 0, 11);
    $ttime = findNum($da);
//    return $ttime;
    return date("Y-m-d H:i:s", $ttime);
}

function findNum($str = '')
{
    $str = trim($str);
    if (empty($str)) {
        return '';
    }
    $temp = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    $result = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if (in_array($str[$i], $temp)) {
            $result .= $str[$i];
        }
    }
    return $result;
}


function GetSize($initsize)
{
    $changesize = '';
    if ($initsize < 1024) {
        $changesize = '1 KB';
    }
    if (1024 < $initsize && $initsize < 1024000) {
        $changesize = (String)round($initsize / 1024, 0) . ' KB';

    } elseif (1024000 < $initsize && $initsize < 1024000000) {
        $changesize = (String)round($initsize / 1024000, 2) . ' MB';

    } elseif (1024000000 < $initsize) {
        $changesize = (String)round($initsize / 1024000000, 4) . ' GB';
    }
    return $changesize;
}

function urlGet($accessKey, $secretKey, $key, $ifsecret)
{
//七牛子域名是一个创建空间时缺省分配的域名，开发者可以在开发者平台 - 空间设置 - 域名设置查看该子域名
    $domain = '7xp8g8.com1.z0.glb.clouddn.com';
//初始化Auth状态：
    $auth = new Auth($accessKey, $secretKey);
// 私有空间中的外链 http://<domain>/<file_key>
    $baseUrl = 'http://' . $domain . '/' . $key;

// 对链接进行签名
    $signedUrl = $auth->privateDownloadUrl($baseUrl);

    if ($ifsecret == 0) {
        $url = $baseUrl;
    } else {
        $url = $signedUrl;
    }
}

function ListFile($accessKey, $secretKey, $prefix, $marker, $limit, $bucket)
{
    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);

    list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);

    if ($err !== null) {
        echo "\n====> list file err: \n";
        var_dump($err);
    } else {
        return $iterms;
    }
}

function DeleteFile($accessKey, $secretKey, $bucket, $key)
{
    $auth = new Auth($accessKey, $secretKey);
    $bucketMgr = new BucketManager($auth);
    $result = $bucketMgr->delete($bucket, $key);
}

echo '
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- TOP NAVBAR -->
    <nav role="navigation" class="navbar navbar-static-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="entypo-menu"></span>
                </button>
                <button class="navbar-toggle toggle-menu-mobile toggle-left" type="button">
                    <span class="entypo-list-add"></span>
                </button>

                <div id="logo-mobile" class="visible-xs">
                   <h1>Apricot<span>v1.3</span></h1>
                </div>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">

                    <li class="dropdown">

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i style="font-size:20px;" class="icon-conversation"></i><div class="noft-red">23</div></a>


                        <ul style="margin: 11px 0 0 9px;" role="menu" class="dropdown-menu dropdown-wrap">
                            <li>
                                <a href="#">
                                    <img alt="" class="img-msg img-circle" src="http://api.randomuser.me/portraits/thumb/men/1.jpg">Jhon Doe <b>Just Now</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <img alt="" class="img-msg img-circle" src="http://api.randomuser.me/portraits/thumb/women/1.jpg">Jeniffer <b>3 Min Ago</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <img alt="" class="img-msg img-circle" src="http://api.randomuser.me/portraits/thumb/men/2.jpg">Dave <b>2 Hours Ago</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <img alt="" class="img-msg img-circle" src="http://api.randomuser.me/portraits/thumb/men/3.jpg"><i>Keanu</i>  <b>1 Day Ago</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <img alt="" class="img-msg img-circle" src="http://api.randomuser.me/portraits/thumb/men/4.jpg"><i>Masashi</i>  <b>2 Mounth Ago</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div>See All Messege</div>
                            </li>
                        </ul>
                    </li>
                    <li>

                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i style="font-size:19px;" class="icon-warning tooltitle"></i><div class="noft-green">5</div></a>
                        <ul style="margin: 12px 0 0 0;" role="menu" class="dropdown-menu dropdown-wrap">
                            <li>
                                <a href="#">
                                    <span style="background:#DF2135" class="noft-icon maki-bus"></span><i>From Station</i>  <b>01B</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <span style="background:#AB6DB0" class="noft-icon maki-ferry"></span><i>Departing at</i>  <b>9:00 AM</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <span style="background:#FFA200" class="noft-icon maki-aboveground-rail"></span><i>Delay for</i>  <b>09 Min</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <span style="background:#86C440" class="noft-icon maki-airport"></span><i>Take of</i>  <b>08:30 AM</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <span style="background:#0DB8DF" class="noft-icon maki-bicycle"></span><i>Take of</i>  <b>08:30 AM</b>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div>See All Notification</div>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i data-toggle="tooltip" data-placement="bottom" title="Help" style="font-size:20px;" class="icon-help tooltitle"></i></a>
                    </li>

                </ul>
                <div id="nt-title-container" class="navbar-left running-text visible-lg">
                    <ul class="date-top">
                        <li class="entypo-calendar" style="margin-right:5px"></li>
                        <li id="Date"></li>


                    </ul>

                    <ul id="digital-clock" class="digital">
                        <li class="entypo-clock" style="margin-right:5px"></li>
                        <li class="hour"></li>
                        <li>:</li>
                        <li class="min"></li>
                        <li>:</li>
                        <li class="sec"></li>
                        <li class="meridiem"></li>
                    </ul>
                    <ul id="nt-title">
                        <li><i class="wi-day-lightning"></i>&#160;&#160;Berlin&#160;
                            <b>85</b><i class="wi-fahrenheit"></i>&#160;; 15km/h
                        </li>
                        <li><i class="wi-day-lightning"></i>&#160;&#160;Yogyakarta&#160;
                            <b>85</b><i class="wi-fahrenheit"></i>&#160;; Tonight- 72 °F (22.2 °C)
                        </li>

                        <li><i class="wi-day-lightning"></i>&#160;&#160;Sttugart&#160;
                            <b>85</b><i class="wi-fahrenheit"></i>&#160;; 15km/h
                        </li>

                        <li><i class="wi-day-lightning"></i>&#160;&#160;Muchen&#160;
                            <b>85</b><i class="wi-fahrenheit"></i>&#160;; 15km/h
                        </li>

                        <li><i class="wi-day-lightning"></i>&#160;&#160;Frankurt&#160;
                            <b>85</b><i class="wi-fahrenheit"></i>&#160;; 15km/h
                        </li>

                    </ul>
                </div>

                <ul style="margin-right:0;" class="nav navbar-nav navbar-right">
                    <li>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" class="admin-pic img-circle" src="http://api.randomuser.me/portraits/thumb/men/10.jpg">Hi, Dave Mattew <b class="caret"></b>
                        </a>
                        <ul style="margin-top:14px;" role="menu" class="dropdown-setting dropdown-menu">
                            <li>
                                <a href="#">
                                    <span class="entypo-user"></span>&#160;&#160;My Profile</a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="entypo-vcard"></span>&#160;&#160;Account Setting</a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="entypo-lifebuoy"></span>&#160;&#160;Help</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <span class="entypo-logout"></span>&#160;&#160;Logout</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="icon-gear"></span>&#160;&#160;Setting</a>
                        <ul role="menu" class="dropdown-setting dropdown-menu">

                            <li class="theme-bg">
                                <div id="button-bg"></div>
                                <div id="button-bg2"></div>
                                <div id="button-bg3"></div>
                                <div id="button-bg5"></div>
                                <div id="button-bg6"></div>
                                <div id="button-bg7"></div>
                                <div id="button-bg8"></div>
                                <div id="button-bg9"></div>
                                <div id="button-bg10"></div>
                                <div id="button-bg11"></div>
                                <div id="button-bg12"></div>
                                <div id="button-bg13"></div>
                            </li>
                        </ul>
                    </li>
                    <li class="hidden-xs">
                        <a class="toggle-left" href="#">
                            <span style="font-size:20px;" class="entypo-list-add"></span>
                        </a>
                    </li>
                </ul>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


    <!-- SIDE MENU -->
    <div id="skin-select">
        <div id="logo">
            <h1>Apricot
                <span>v1.3</span>
            </h1>
        </div>

        <a id="toggle">
            <span class="entypo-menu"></span>
        </a>
        <div class="dark">
            <form action="#">
                <span>
                    <input type="text" name="search" value="" class="search rounded id_search" placeholder="Search Menu..." autofocus="">
                </span>
            </form>
        </div>


        <div class="skin-part">
            <div id="tree-wrap">
                <div class="side-bar">
                    <ul class="topnav menu-left-nest">
                        <li>
                            <a href="#" style="border-left:0px solid!important;" class="title-menu-left">

                                <span class="widget-menu"></span>
                                <i data-toggle="tooltip" class="entypo-cog pull-right config-wrap"></i>

                            </a>
                        </li>

                        <li>
                            <a class="tooltip-tip ajax-load" href="#" title="Blog App">
                                <i class="icon-document-edit"></i>
                                <span>T-List</span>

                            </a>
                            <ul>
                                <li>
                                    <a class="tooltip-tip2 ajax-load" href="#" title="List-1"><i class="entypo-doc-text"></i><span>List-1</span></a>
                                </li>
                                <li>
                                    <a class="tooltip-tip2 ajax-load" href="#" title="List-2"><i class="entypo-newspaper"></i><span>List-2</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="tooltip-tip ajax-load" href="#" title="Social">
                                <i class="icon-feed"></i>
                                <span>T-test</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap-fluid">
        <div class="container-fluid paper-wrap bevel tlbr">

            <div class="content-wrap">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="nest" id="Blank_PageClose">
                            <div class="title-alt">
                                <h3>基于云存储的NPO数据共享平台</h3>
                                <div class="titleClose">
                                    <a class="gone" href="#Blank_PageClose">
                                        <span class="entypo-cancel"></span>
                                    </a>
                                </div>
                                <div class="titleToggle">
                                    <a class="nav-toggle-alt" href="#Blank_Page_Content">
                                        <span class="entypo-up-open"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="body-nest" id="Blank_Page_Content">

<div id="upfile">
<form id="upfile_form" method="POST" action="http://upload.qiniu.com/"
          enctype="multipart/form-data">
        <input name="token" type="hidden" value="' . $token . '"/>
        <input name="x:price" type="hidden" value="1500.00">
        <input name="file" id="file" type="file" />
        <input type="submit" class="btn btn-primary" value="确认上传"/>
    </form>
</div>
<div id="list_file">
<table class="table">
                <tr>
                  <th id="th_time">ID号</th>
                  <th id="th_time">上传时间</th>
                  <th id="th_name">文件名</th>
                  <th id="th_size">大小</th>
                  <th id="th_size">分享次数</th>
                  <th id="th_deal">操作</th>
                </tr>
';

DealPage($result, $pagelimit, $page, $allcount);

echo '</table></div>';

echo '<div id="pagediv"><ul id="pageul">';
if ($pagelen < 4 && $page < 4) {

    for ($j = 1; $j <= $pagelen; $j++) {
        echo '<a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $j . '">' . $j . '</a>';
    }
}
if ($pagelen > 4 && $page < 4) {
    for ($j = 1; $j <= 4; $j++) {
        echo '<a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $j . '">' . $j . '</a>';
    }
    echo '<a id="pageitem" href="#">...</a>';
    echo '<a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $pagelen . '">' . $pagelen . '</a>';
}
if ($pagelen >= 4 && $page >= 4 && $page <= $pagelen - 4) {
    echo '
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=1">1</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($page - 2) . '">' . ($page - 2) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($page - 1) . '">' . ($page - 1) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $page . '">' . $page . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($page + 1) . '">' . ($page + 1) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($page + 2) . '">' . ($page + 2) . '</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $pagelen . '">' . $pagelen . '</a>
            ';
}
if ($pagelen > 4 && $page > ($pagelen - 4)) {
    echo '
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=1">1</a>
            <a id="pageitem" href="#">...</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($pagelen - 4) . '">' . ($pagelen - 4) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($pagelen - 3) . '">' . ($pagelen - 3) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($pagelen - 2) . '">' . ($pagelen - 2) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . ($pagelen - 1) . '">' . ($pagelen - 1) . '</a>
            <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $pagelen . '">' . $pagelen . '</a>
            ';
}

echo '<a id="pageitem2" class="btn btn-default btn-lg active" href="preindex.php?page=' . pgDeal($page - 1, $pagelen) . '">上一页</a>
        <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . pgDeal($page + 1, $pagelen) . '">下一页</a>
        <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=1">首页</a>
        <a id="pageitem" class="btn btn-default btn-lg active" href="preindex.php?page=' . $pagelen . '">尾页</a>

        <form id="pagejump_form" method="get" action="preindex.php?"
          >
            <input class="form-control" id="page_edit" type="text" name="page">
            <input type="submit" class="btn btn-default" value="跳转">
        </form>

        <a id="tool" href="https://github.com/qiniu/qsunsync">云上传工具下载</a>
        ';
echo '</ul></div>';

function pgDeal($page, $pagelentg)
{
    if ($page > $pagelentg) {
        return $pagelentg;
    } elseif ($page < 1) {
        return 1;
    } else {
        return $page;
    }
}

?>
</div>
</div>
</div>
</div>

<div class="footer-space"></div>
<div id="footer">
    <div class="devider-footer-left"></div>
    <div class="time">
        <p id="spanDate">

        <p id="clock">
    </div>
    <div class="copyright">Make with Love
        <span class="entypo-heart"></span>Collect from <a href="#" title="主页" target="_blank">主页</a> All Rights Reserved
    </div>
    <div class="devider-footer"></div>

</div>
</div>
</div>

<script type="text/javascript" src="assets/js/preloader.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/app.js"></script>
<script type="text/javascript" src="assets/js/load.js"></script>
<script type="text/javascript" src="assets/js/main.js"></script>

</div></body>

</html>

