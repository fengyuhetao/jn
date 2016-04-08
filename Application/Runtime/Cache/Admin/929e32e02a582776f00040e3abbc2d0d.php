<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>商品列表</title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/jn/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/jn/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<link href="/jn/Public/datepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="/jn/Public/datepicker/jquery-1.7.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/datepicker/jquery-ui-1.9.2.custom.min.js"></script>

<script type="text/javascript" charset="utf-8" src="/jn/Public/datepicker/datepicker_zh-cn.js"></script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/jn/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link;?>"><?php echo ($_page_btn_name); ?></a></span>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> -<?php echo ($_page_title); ?> </span>
    <div style="clear:both"></div>
</h1>

<!--页面中的内容-->

<div class="list-div" id="listdiv">
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Goods/goodsNumber/id/4.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
            <?php foreach ($attrData as $k => $v): ?>
            	<th><?php echo ($v[0]['attr_name']); ?></th>
            <?php endforeach ?>
            	<th width="150">库存量</th>
            	<th width="60">操作</th>
            </tr>
            <?php  $opt = "+"; if ($gnData): ?>
            	<?php foreach ($gnData as $k0 => $v0): if($k0 == 0) $opt = "+"; else $opt = "-"; ?>
      			<tr>
      				<?php foreach ($attrData as $k => $v): ?>
					<td>
					<select name="goods_attr_id[]">
						<option value="">请选择</option>
						<?php foreach ($v as $k1 => $v1): if(strpos(','.$v0['goods_attr_id'].',', ','.$v1['id'].',') !== false) $select = 'selected="selected"'; else $select = ''; ?>
							<option value="<?php echo ($v1["id"]); ?>" <?php echo ($select); ?>><?php echo ($v1["attr_value"]); ?></option>
						<?php endforeach ?>
					</select>
					</td>
					<?php endforeach ?>
                	<td><input type="text" name="goods_number[]" value="<?php echo ($v0["goods_number"]); ?>"></td>
            		<td><input type="button" onclick="addnew(this);" value="<?php echo ($opt); ?>"/></td>
      				</tr>
            	<?php endforeach ?>
            <?php else: ?>
	            <tr>
				<?php foreach ($attrData as $k => $v): ?>
					<td>
						<select name="goods_attr_id[]">
							<option value="">请选择</option>
							<?php foreach ($v as $k1 => $v1): ?>
								<option value="<?php echo ($v1["id"]); ?>"><?php echo ($v1["attr_value"]); ?></option>
							<?php endforeach ?>
						</select>
					</td>
				<?php endforeach ?>
	                <td><input type="text" name="goods_number[]"></td>
	            	<td><input type="button" onclick="addnew(this);" value="<?php echo ($opt); ?>"/></td>
	            </tr>
	        <?php endif ?>
        </table>
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript">
/**
 * 点击a标签后复制一个新的该标签
 */
function addnew(btn){
    var newB = $(btn).parent().parent();
    if($(btn).val() == "+")
   	{
   		var table = newB.parent();
   		var newtr = newB.clone();
   		//把+变为-
    	newtr.find(":button").val('-');
    	table.append(newtr);
   	}
   	else
   	{
   		newB.remove(); 
   	}	 
}
</script>


<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>