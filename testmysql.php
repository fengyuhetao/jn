<?php 
 
//使用数据库中的锁处理并发

$conn = mysql_connect("localhost", "root", "");
mysql_select_db('test');

mysql_query('lock table a write');
$rs = mysql_query("select id from a limit 1", $conn);
$result = mysql_fetch_array($rs);
$id = $result[0];
$id--;
mysql_query("update a set id = $id");
mysql_query('unlock tables');
mysql_close($conn);

?>