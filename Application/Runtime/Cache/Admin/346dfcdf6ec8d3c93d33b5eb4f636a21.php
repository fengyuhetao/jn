<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="/jn/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/jn/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" language="javascript" src="/jn/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<form name="main_form" method="POST" action="/jn/index.php/Admin/Goods/add.html" enctype="multipart/form-data">
	商品名称:<input type="text" name="goods_name" /><br />
	商品价格:<input type="text" name="price" /><br />
	商品logo:<input type="file" name="logo" /><br />
	商品描述:<textarea name="goods_desc" id="goods_desc"></textarea><br />
	是否上架:
	<input type="radio" name="is_on_sale" value="1" checked="checked" />上架
	<input type="radio" name="is_on_sale" value="0" />下架
	<br />
	<input type="submit" value="提交" />
	<a href="<?php echo U('lst'); ?>">列表</a>
</form>
<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
</body>
</html>
<script>
UE.getEditor('goods_desc', {
	"initialFrameWidth" : "100%",  // 宽
	"initialFrameHeight" : 350,     // 高
	"maximumWords" : 50000             // 最可以输入的字符数
});
//使用ajax提交表单
$("form[name='main_form']").submit(function (){
	$.ajax({
		type : "POST",
		url : "/jn/index.php/Admin/Goods/add.html",
		data : $(this).serialize(), //收集表单中的数据
		dataType : "json",  //标记服务器返回的是JSON数据
		success : function(data){   //ajax执行完之后的回调函数
			//判断添加是否成功
			alert(data.url);
			if(data.status == 1){
				alert(data.info);
				locate.href = data.url;
			}else{
				alert(data.info);
			}

		}
	});
	//阻止表单提交
	return false;
});
</script>