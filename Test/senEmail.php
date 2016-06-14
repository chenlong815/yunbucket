<?php
$now = date("Y-m-d h:i:s");
$headers = 'From: name<281910885@qq.com>';
$body = "hi, this is a test mail.\nMy email: 281910885@qq.com";
$subject = "test mail";
$to = "18810007943@163.com";
if (mail($to, $subject, $body, $headers)) {
    echo 'success!';
} else {
    echo 'fail';
}
?>