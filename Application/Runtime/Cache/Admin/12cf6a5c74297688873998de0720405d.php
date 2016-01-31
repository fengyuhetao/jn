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
</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo U('add'); ?>">添加商品</a></span>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品列表 </span>
    <div style="clear:both"></div>
</h1>
<div class="form-div">
<form action="/jn/index.php/Admin/Goods/lst.html" name="searchForm">
<input type="hidden" name="p" value="1" />
<p>商品名称：<input type="text" name="goods_name" value="<?php echo I('get.goods_name'); ?>" /></p>

<p>价　　格：<input type="text" size="8" name="start_price" value="<?php echo I('get.start_price'); ?>" /> ~ 
		<input type="text" size="8" name="end_price" value="<?php echo I('get.end_price'); ?>" /></p>
		
<p>添加时间：<input type="text" size="8" id="start_addtime" name="start_addtime" value="<?php echo I('get.start_addtime'); ?>" /> ~ 
		<input type="text" size="8" id="end_addtime" name="end_addtime" value="<?php echo I('get.end_addtime'); ?>" /></p>
		
<p>上否上架：<input type="radio" name="is_on_sale" value="-1" <?php if(I('get.is_on_sale', -1) == -1) echo 'checked="checked"'; ?> />全部
		<input type="radio" name="is_on_sale" value="1" <?php if(I('get.is_on_sale') == 1) echo 'checked="checked"'; ?> />是
		<input type="radio" name="is_on_sale" value="0" <?php if(I('get.is_on_sale') === '0') echo 'checked="checked"'; ?> />否</p>
		
<p>是否删除：<input type="radio" name="is_delete" value="-1" <?php if(I('get.is_delete', -1) == -1) echo 'checked="checked"'; ?> />全部
		<input type="radio" name="is_delete" value="1" <?php if(I('get.is_delete') == 1) echo 'checked="checked"'; ?> />是
		<input type="radio" name="is_delete" value="0" <?php if(I('get.is_delete') === '0') echo 'checked="checked"'; ?> />否</p>

<p><input type="submit" value="搜索" /></p>
		
排序方式：<input onclick="parentNode.submit();" type="radio" name="odby" value="id_asc" <?php if(I('get.odby') == 'id_asc') echo 'checked="checked"'; ?> />根据添加时间升序
		<input onclick="parentNode.submit();" type="radio" name="odby" value="id_desc" <?php if(I('get.odby', 'id_desc') == 'id_desc') echo 'checked="checked"'; ?> />根据添加时间降序
		<input onclick="parentNode.submit();" type="radio" name="odby" value="price_asc" <?php if(I('get.odby') == 'price_asc') echo 'checked="checked"'; ?> />根据价格升序
		<input onclick="parentNode.submit();" type="radio" name="odby" value="price_desc" <?php if(I('get.odby') == 'price_desc') echo 'checked="checked"'; ?> />根据价格降序<br />
</form>
</div>
<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
				<th>id</th>
				<th>添加时间</th>
				<th>商品名称</th>
				<th>LOGO</th>
				<th>价格</th>
				<th>描述</th>
				<th>是否上架</th>
				<th>是否删除</th>
				<th>操作</th>
			</tr>
            <?php foreach ($data as $k => $v): ?>
			<tr>
				<td><?php echo ($v["id"]); ?></td>
				<td><?php echo date('Y-m-d H:i:s', $v['addtime']); ?></td>
				<td><?php echo ($v["goods_name"]); ?></td>
				<td><img src="/jn/Public/Uploads/<?php echo ($v["sm_logo"]); ?>" /></td>
				<td><?php echo ($v["price"]); ?></td>
				<td><?php echo ($v["goods_desc"]); ?></td>
				<td><?php echo $v['is_on_sale'] == 1 ? '上架' : '下架'; ?></td>
				<td><?php echo $v['is_delete'] == 1 ? '已删除' : '未删除'; ?></td>
				<td>
				<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p', 1)); ?>">修改</a>
				<a onclick="return confirm('确定要删除吗？');" href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p', 1)); ?>">删除</a>
				</td>
			</tr>
			<?php endforeach; ?>
			<tr><td colspan="8"><?php echo ($page); ?></td></tr>
        </table>
    </div>
</form>
<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>
<script>
$("#start_addtime").datepicker({ dateFormat: "yy-mm-dd" });
$("#end_addtime").datepicker({ dateFormat: "yy-mm-dd" });
</script>