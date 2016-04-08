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

<div class="main-div">
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Category/add.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
			<tr>
				<td class="label">上级权限：</td>
				<td>
					<select name="parent_id">
						<option value="0">顶级权限</option>
						<?php foreach ($parentData as $k => $v): ?>						<option value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']).$v['cate_name']; ?></option>
						<?php endforeach; ?>					</select>
				</td>
			</tr>
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input  type="text" name="cate_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">筛选属性：</td>
                <td>
                <ul style="list-style: none">
                    <li>
                        <a href="javascript:void(0);" onclick="addNew(this);">[+]</a>
                        <select name="type_id[]">
                            <option value="">选择类型</option> 
                            <?php foreach ($typeData as $k => $v): ?>
                                <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                            <?php endforeach ?>
                        </select>
                        <select name="attr_id[]">
                            <option value="">选择属性</option>
                        </select>
                    </li>
                </ul>
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>
<script>
$("select[name='type_id[]']").change(function(){
    var _this = $(this);
    var typeId = $(this).val();
     var opt = "<option value=''>请选择属性</option>";
    //如果选择了类型
    if(typeId != "")
    {
        $.ajax({
            type : "GET",
            url : "<?php echo U('Admin/Goods/ajaxGetAttr', '', false);?>/type_id/"+typeId,
            dataType : "json",
            success : function(data)
            {
                $(data).each(function(k, v) {
                    opt += "<option value='"+v.id+"'>"+v.attr_name+"</option>";
                });
                _this.next("select").html(opt);
            }
        });
    }
    else
    {
        _this.next("select").html(opt);
    }
});

function addNew(a)
{
    if($(a).text() == '[-]')
        $(a).parent().remove();
    else
    {
        var li = $(a).parent();
        var newLi = li.clone(true); //深度克隆，把标签和事件也克隆过来
        newLi.find("a").text("[-]");
        li.after(newLi);
    }   
}

</script>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>