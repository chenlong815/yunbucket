<?php

$to = "1158387748@qq.com";
$subject = "HTML email";

$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>This email contains HTML Tags!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

$message = str_replace("\n.", "\n..", $message);

// 当发送 HTML 电子邮件时，请始终设置 content-type
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

// 更多报头
$headers .= 'From: <281910885@qq.com>' . "\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

echo mail($to, $subject, $message, $headers);
?>