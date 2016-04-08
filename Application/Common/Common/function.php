<?php
/**
 * 邮件发送
 * @param  [string] $to      [邮件发送目标]
 * @param  [string] $title   [发送主题]
 * @param  [string] $content [发送内容]
 * @return [type]          [description]
 */
function sendMail($to, $title, $content)
{
	require_once('./Application/PHPMailer_v5.1/class.phpmailer.php');
    $mail = new PHPMailer();
    // 设置为要发邮件
    $mail->IsSMTP();
    // 是否允许发送HTML代码做为邮件的内容
    $mail->IsHTML(TRUE);
    // 是否需要身份验证
    $mail->SMTPAuth = TRUE;
    $mail->CharSet = 'UTF-8';
    /*  邮件服务器上的账号是什么 */
    $mail->From = C('MAIL_ADDRESS');
    $mail->FromName = C('MAIL_FROM');
    $mail->Host = C('MAIL_SMTP');
    $mail->Username = C('MAIL_LOGINNAME');
    $mail->Password = C('MAIL_PASSWORD');
    // 发邮件端口号默认25
    $mail->Port = 25;
    // 收件人
    $mail->AddAddress($to);
    // 邮件标题
    $mail->Subject = $title;
    // 邮件内容
    $mail->Body = $content;
    return ($mail->Send());
}

function removeXSS($val)
{
	// 实现了一个单例模式，这个函数调用多次时只有第一次调用时生成了一个对象之后再调用使用的是第一次生成的对象（只生成了一个对象），使性能更好
	static $obj = null;
	if($obj === null)
	{
		require('./HTMLPurifier/HTMLPurifier.includes.php');
		$config = HTMLPurifier_Config::createDefault();
		// 保留a标签上的target属性
		$config->set('HTML.TargetBlank', TRUE);
		$obj = new HTMLPurifier($config);  
	}
	return $obj->purify($val);  
}

/**
 * 上传单个图片
 * @param  string $imgName [图片名称]
 * @param  string $dirName [保存的目录名称]
 * @param  array  $thumb   [需要生成的缩略图的大小]
 * @return array  	       [返回错误码和所有图片保存的路径]
 */
function uploadOne($imgName, $dirName, $thumb = array())
{
	// 上传LOGO
	if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
	{
		//文件上传的根目录
		$rootPath = C('IMG_upload');

		// 实例化上传类
		$upload = new \Think\Upload(array(
			'rootPath' => $rootPath,
		));

		// 设置附件上传大小
		$upload->maxSize = (int)C('IMG_maxSize') * 1024 * 1024;

		// 设置附件上传类型
		$upload->exts = C('IMG_exts');

		// 图片二级目录的名称
		$upload->savePath = $dirName . '/'; 

		// 上传文件 
		// TP框架中的upload方法会把表单中所有的图片全部处理一遍,想要单独上传某个文件，可以指定上传图片的名字
		// 指定上传的图片
		$info   =   $upload->upload(array($imgName => $_FILES[$imgName]));
		if(!$info)
		{
			return array(
				'ok' => 0,
				'error' => $upload->getError(),
			);
		}
		else
		{
			$reeult['ok'] = 1;

			//保存文件相对于根目录下的保存路径
		    $result['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];

		    // 判断是否生成缩略图
		    if($thumb)
		    {
		    	$image = new \Think\Image();
		    	// 循环生成缩略图
		    	foreach ($thumb as $k => $v)
		    	{
		    		//保存图片的额缩略图相对于根目录下的保存路径
		    		$result['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];

		    		// 打开要处理的图片
				    $image->open($rootPath.$logoName);
				    $image->thumb($v[0], $v[1])->save($rootPath.$result['images'][$k+1]);
		    	}
		    }
		    return $result;
		}
	}
	else
	{
		return array(
				'ok' => 0,
				'error' => "不存在该上传图片，无法上传",
			);
	}
}

/**
 * 根据url显示图片
 * @param  string $url    
 * @param  string $width  [需要的显示图片的宽度]
 * @param  string $height [需要显示的图片的高度]
 */
function showImage($url, $width = '', $height = ''){
	if($width)
		$width = "width = '$width'";
	if($height)
		$height = "height = '$height'";
	$url = C('IMG_rootPath').$url;
	echo "<img src = '$url' $width $height alt='商品logo'>";
}

/**
 * 删除图片
 * @param  array $logo [一维数组,所有要删除图片的路径]
 */
function deleteImage($logo){
	$rp = C('IMG_rootPath');
	if(is_array($logo))
	{
		foreach ($logo as $v) {
			@unlink($rp.$v);
		}
	}
	else 
	{
		@unlink($rp.$logo);
	}	
	// @unlink($rp.$logo['logo']);
	// @unlink($rp.$logo['sm_logo']);
}

/**
 * 判断是否有图片
 * @param  array $imgName  [图片名称]
 * @return boolean          
 */
function hasImage($imgName){
	foreach ($_FILES[$imgName]['error'] as $v) {
		
		//如果存在一张图片没有上传成功，就返回false
		if($v != 0)
		{
			return false;
		}
	}
	return true;
}

/**
 * 根据商品属性的id进行二维数组排序
 * @param  array $a [description]
 * @param  array $b [description]
 * @return number   [description]
 */
function attr_id_sort($a, $b)
{
	if($a['attr_id'] == $b['attr_id']){
		return 0;
	}
	return ($a['attr_id'] < $b['attr_id']) ? -1 : 1;
}
