<?php

require 'mysql.php';

if (!isset($_POST['url']) || !isset($_POST['key']) || !isset($_POST['npass'])) {
    echo '参数错误';
    return;
}

$url = $_POST['url'];
$file_name = $_POST['key'];
$pass = $_POST['npass'];

function file_typeget($file_name)
{
    $name_Array = explode(".", $file_name);

    $len = count($name_Array);

    $file_type = $name_Array[$len - 1];

    switch ($file_type) {
        case "doc":
            $contype = 'application/msword';
            break;
        case "txt":
            $contype = 'text/plain';
            break;
        case "gif":
            $contype = 'image/gif';
            break;
        case "avi":
            $contype = 'video/avi';
            break;
        case "mp4":
            $contype = 'video/mpeg4';
            break;
        case "mp3":
            $contype = 'audio/mp3';
            break;
        case "ppt":
            $contype = 'application/x-ppt';
            break;
        case "rtf":
            $contype = 'application/msword';
            break;
        case "pdf":
            $contype = 'application/pdf';
            break;
        case "dcx":
            $contype = 'application/x-dcx';
            break;
        case "jpg":
            $contype = 'image/jpeg';
            break;
        case "zip":
            $contype = 'application/x-zip-compressed';
            break;
        case "rar":
            $contype = 'application/octet-stream';
            break;
        default:
            $contype = 'application/' . $file_type;
            break;
    }
    return $contype;
}

$tim = date('Y-m-d H:i:s');
$time_record = strtotime($tim);

$deadtime = 3600 * 24 * 7;

if (empty($pass)) {
    require_once 'Er_nonePassword.html';
    return;
}

$mysql = new mysql();

$sqlstr1 = "select * from email_permission where docname='{$file_name}' and password='{$pass}'";
$rsult = $mysql->Select($sqlstr1);
$re = mysql_num_rows($rsult);
if (!$re) {
    require_once 'Er_errorPassword.html';
    return;
}

$sqlstr2 = "select * from email_permission where docname='{$file_name}' and deadline>({$time_record}-{$deadtime})";
$rsult = $mysql->Select($sqlstr2);
$re = mysql_num_rows($rsult);
if ($re) {
    downLoad($file_name, $url);
} else {
    require_once 'Er_expiredLinkDownload.html';
}

//downLoad($file_name,$url);

function downLoad($file_name, $url)
{
    $content_type = file_typeget($file_name);

    header("Content-Disposition:attachment;filename='" . $file_name . "'");
    header("Content-type:" . $content_type);

    readfile($url);
}
