<?php
require "email.class.php";

$mail=new Email();

$mail->setTo("18810007943@163.com"); //收件人
//$mail-> setCC("b@b.com,c@c.com"); //抄送
//$mail-> setCC("d@b.com,e@c.com"); //秘密抄送
$mail->setFrom("281910885@qq.com");//发件人
$mail->setSubject("主题") ; //主题
$mail->setText("文本格式") ;//发送文本格式也可以是变量
$mail->setHTML("html格式") ;//发送html格式也可以是变量
//$mail->setAttachments("c:a.jpg") ;//添加附件,需表明路径

//$mail->send(); //发送邮件

//if($mail->send()){
//    echo 'Seccess';
//}else{
//    echo 'failed';
//}