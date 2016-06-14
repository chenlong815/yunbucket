<?php
$conn = mysql_connect("localhost", "root", "");
$maxnum = 2; //每页记录条数
mysql_select_db("test", $conn);
$query1 = "SELECT COUNT(*) AS totalrows FROM test ";
$result1 = mysql_query($query1, $conn) or die(mysql_error());
$row1 = mysql_fetch_assoc($result1);
$totalRows1 = $row1['totalrows']; //数据集总条数
$totalpages = ceil($totalRows1 / $maxnum); //分页总数
if (!isset($_GET['page']) || !intval($_GET['page']) || $_GET['page'] > $totalpages) $page = 1; //对3种出错进行处理
//在url参数page不存在时，page不为10进制数时，page大于可分页数时，默认为1
else $page = $_GET['page'];
$startnum = ($page - 1) * $maxnum; //从数据集第$startnum条开始读取记录，这里的数据集是从0开始的
$query = "SELECT * FROM test LIMIT $startnum,$maxnum"; //选择出符合要求的数据 从$startnum条数据开始，选出$maxnum行
$result = mysql_query($query, $conn) or die(mysql_error());
$row = mysql_fetch_assoc($result);
?>
