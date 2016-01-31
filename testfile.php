<?php 
//打开锁文件
$fp = fopen('./a.lock', 'r');
//开启排他锁     LOCK_SH(共享锁)
flock($fp, LOCK_EX);
//关闭锁
flock($fp, LOCK_UN);
fclose($fp);
?>