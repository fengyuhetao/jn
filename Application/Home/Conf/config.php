<?php 

return array(
	'HTML_CACHE_ON'     =>    false, // 开启静态缓存
	'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
	'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
	'HTML_CACHE_RULES'  =>    array(  // 定义静态缓存规则         
		//为首页创建缓存
		'Index:index'   =>    array('index', '3600'), 
		//为每件商品生成一个缓存文件
		'Index:goods'   =>   array('{id|goodsdir}/goods_{id}', '3600'),
		),
	/******* 发送邮件的配置 **********/
	'MAIL_ADDRESS'      => 'he1779168840@126.com',        //发送人的email
	'MAIL_FROM'			=> 'ht',						  //发送人的姓名
	'MAIL_SMTP' 		=> 'smtp.126.com',				  //邮件服务器的地址
	'MAIL_LOGINNAME'	=> 'he1779168840',			
	'MAIL_PASSWORD'		=> '',
	);

function goodsdir($id)
{
	return ceil($id/100);	//计算出缓存的目录
}


?>