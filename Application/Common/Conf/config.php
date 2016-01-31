<?php
return array(
	'DEFAULT_MODULE' => 'Admin',
	'DB_TYPE'=>'mysql',
	'DB_HOST'=>'127.0.0.1',
	'DB_NAME'=>'jn',
	'DB_USER'=>'root',
	'DB_PWD'=>'',
	'DB_PREFIX'=>'jn_',
	'DB_CHARSET'=>'utf8',
	'DB_PORT'=>'3306',
	/********** 图片相关的配置 ************/
	'IMG_maxSize' => '3M',
	'IMG_exts' => array('jpg', 'pjpeg', 'bmp', 'gif', 'png', 'jpeg'),
	'IMG_rootPath' => './Public/Uploads/',
	/********** 修改I函数底层过滤时使用的函数 ***********/
	'DEFAULT_FILTER' => 'trim,removeXSS',
	/********** MD5用来复杂化的 ****************/
	'MD5_KEY' => 'fjasdufjoi340952834tja;~u9345/oisdf',
);