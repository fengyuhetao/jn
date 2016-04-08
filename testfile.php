<?php 
//打开锁文件
$fp = fopen('./a.lock', 'r');
//开启排他锁     LOCK_SH(共享锁)
flock($fp, LOCK_EX);
//关闭锁
flock($fp, LOCK_UN);
fclose($fp);
?>

<!-- 事务 -->
<?php 
	mysql_query('START TRANSACTION');
	$rs = mysql_query('update a set id=1');
	$rs1 = mysql_query('update b set id=2');
	if($rs && $rs1)
		mysql_query('COMMIT');
	else
		mysql_query('ROLLBACK');

?>