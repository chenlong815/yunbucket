<html>
<head>
    <title>海贝数据创新共享平台 请输入密码</title>
    <meta charset="utf-8">
    <link href="../css/permissionPage.css" type="text/css" rel="stylesheet">
</head>
<body>

<h2 id="ph2">海贝数据创新共享平台</h2>

<div id="ptitle">
    <h1 id="pp_h2" align="center">自由存，随心享</h1>
</div>

<div id="pdown">
    <div id="pcen" align="center">
        <?php
        require 'mysql.php';

        if (empty($_GET['url']) || empty($_GET['key'])) {
            echo "没有提供任何参数！";
            return false;
        }
        $url = $_GET['url'];
        $file_name = $_GET['key'];

        //echo $url.'--'.$file_name;

        echo '<form id="per_form" method="get" action="permissionPage.php" enctype="multipart/form-data" >
         <input type="text" id="ppass" name="npass">
         <input type="hidden" id="purl" name="url" value="' . $url . '">
         <input type="hidden" id="pkey" name="key" value="' . $file_name . '">
         <input type="submit" id="psubmit" value="确认提取"/>
     </form>';

        if (isset($_GET['npass'])) {
            if (empty($_GET['npass'])) {
                echo '<h5>密码不能为空</h5>';
            } else {
                $pass = $_GET['npass'];
//    echo $pass;

                $if_true = PerDeal($file_name, $pass);
                if ($if_true) {
//        echo '<h5>密码正确</h5>';
//        require_once 'permissionDeal.php';

                    require_once 'downLoadAction.php';
                } else {
                    echo '<h5>密码错误</h5>';
                }
            }
        } else {

        }

        function PerDeal($file_name, $pass)
        {
            $sqlstr = "select * from email_permission where docname='{$file_name}' and password='{$pass}'";
            $mysql = new mysql();
            $rsult = $mysql->Select($sqlstr);
            $re = mysql_num_rows($rsult);
            if ($re) {
                return true;
            } else {
                return false;
            }
        }

        ?>
    </div>
    <p id="func" align="center">海贝数据创新共享平台</p>
</div>

</body>
