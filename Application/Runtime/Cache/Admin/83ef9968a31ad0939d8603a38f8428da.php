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
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Attribute/add/type_id/1.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">属性名称：</td>
                <td>
                    <input  type="text" name="attr_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">属性的类型：</td>
                <td>
                    <input type="radio" value="0" name="attr_type" checked="checked">唯一&nbsp;
                    <input type="radio" value="1" name="attr_type">可选
                </td>
            </tr>
            <tr>
                <td class="label">属性的可选值：</td>
                <td>
                    <input  type="text" name="attr_option_values" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">所在类型：</td>
                <td>
                    <select name="type_id">
                        <?php foreach ($typeData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>" <?php if($v['id'] == I('get.type_id')) echo 'selected="selected"';?>><?php echo ($v["type_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
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
</script>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>