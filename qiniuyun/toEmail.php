<?php
header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime", 0);
require 'class.phpmailer.php';
require 'mysql.php';

define('THISPATH', dirname(__FILE__));

$url = $_POST['downurl'];
$key = $_POST['key'];

//写入数据库该条分享记录信息
$tim = date('Y-m-d H:i:s');
$time_record = strtotime($tim);

$pass_record = rand(100000, 999999);

// 检测邮件
//if(empty($_POST['subject']) || empty($_POST['receiver']) || empty($_POST['content']))
//   {
//	echo "没有提供任何参数！";
//	return false;
//   }

//$subject = $_POST['subject'];
//$receiver = $_POST['receiver'];
//$content = $_POST['content'];

if (empty($_POST['receiver'])) {
//    $receiver='1158387748@qq.com';
//    $receiver='diaoboyu2012@ict.ac.cn';
//    $receiver='hwl@wsn.org.cn';
//    $receiver='18810007943@163.com';
//    $subject='无收件人邮件';
    require 'Er_noneReceiver.html';
    return;

} else {
    $receiver = $_POST['receiver'];
}

if (empty($_POST['subject'])) {
    $subject = '海贝数据创新共享平台';
}
if (empty($_POST['content'])) {
    $content = '
您好，这是来自海贝数据创新共享平台的邮件

<br/>您申请的数据已经打包完毕，请通过以下链接下载

<br/>提取链接：<a href="http://123.57.242.185/yunbucket/qiniuyun/permissionDownLoad.php?url=' . $url . '&key=' . $key . '"
target="_blank">' . $key . '</a>
<br/>提取码：' . $pass_record . '

<br/>数据7天内有效。

<br/>数据仅供非盈利目的使用，一切解释权归海贝团队所有。
<br/>
<br/>感谢您对海贝的支持！
<br/>
<br/>
<br/>如对服务有疑问或建议，请联系：service@seashelldata.org
<br/>如对数据的内容有疑问，请联系：tech@seashelldata.org


<br/>海贝团队

';
}

$email = 'data@seashelldata.org';

try {
    $mail = new PHPMailer(true);
    $mail->IsSMTP(); // 启用SMTP
    $mail->CharSet = 'UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
    $mail->SMTPAuth = true; //开启认证

    $mail->Port = 25; //邮件发送端口

    $mail->SMTPAuth = true; //启用SMTP认证

    $mail->CharSet = "UTF-8"; //字符集
    $mail->Encoding = "base64"; //编码方式

    $mail->Host = "smtp.exmail.qq.com";
    $mail->Username = "data@seashelldata.org";
    $mail->Password = "Cl155213"; //密码

//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示

    $mail->AddReplyTo($email, $subject); //回复地址

    $mail->AddBCC('service@seashelldata.org');
    $mail->AddBCC('tech@seashelldata.org');

//$mail->From = "281910885@qq.com";
    $mail->From = "data@seashelldata.org";

    $mail->FromName = $subject;

    $mail->AddAddress($receiver);
    $mail->Subject = $subject;

//邮件主体内容
    $mail->Body = $content;

    $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
    $mail->WordWrap = 80; // 设置每行字符串的长度

//$mail->AddAttachment("f:/test.png"); //可以添加附件

    $mail->IsHTML(true);

    $mail->Send();

    WritetoSql($receiver, $key, $time_record, $pass_record);

//echo '邮件已发送';
    require 'Suc_uploadSuccess.html';

} catch (phpmailerException $e) {
    echo "邮件发送失败：" . $e->errorMessage();
    require 'Er_failedEmail.html';
}

function WritetoSql($receiver, $key, $time_record, $pass_record)
{
    $sql_str = "insert into email_permission(id,email_address,password,deadline,docname) values (0,'{$receiver}','{$pass_record}','{$time_record}','{$key}')";
//    echo $sql_str;
    $mysql = new mysql();

    $mysql->Excute($sql_str);
    $mysql->Close();
}

?>