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
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Role/add.html" enctype="multipart/form-data">
        <table cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">角色名称：</td>
                <td>
                    <input  type="text" name="role_name" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">权限列表</td>
                <td>
                    <?php foreach ($priData as $k => $v): ?>
                        <?php echo str_repeat('-', $v['level']*8);?>
                        <input level="<?php echo ($v["level"]); ?>" type="checkbox" name="pri_id[]" value="<?php echo ($v["id"]); ?>"><?php echo ($v["pri_name"]); ?><br/>
                    <?php endforeach ?>
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
//为所有复选框添加绑定事件
$(":checkbox").click(function (){
    //获取当前点击的复选框的等级
    var cur_level = $(this).attr("level");

    //判断如果是选中状态
    if($(this).attr("checked")){
        var tmplevel = cur_level;
        //先选出该权限的所有上级权限
        var prev = $(this).prevAll(":checkbox");
        //循环每一个前面的复选框，判断是否是上级权限
        $(prev).each(function(k, v){
            //判断
            if($(v).attr("level") < tmplevel){
                tmplevel--;
                $(v).attr("checked", "checked");
            }
        });
        //所有子权限也全部选中
        var nextv = $(this).nextAll(":checkbox");
        //循环每一个下一级的复选框，判断是否是子级权限
        $(nextv).each(function(k, v){
            //判断
            if($(v).attr("level") > cur_level){
                $(v).attr("checked", "checked");
            }else{
                return false;
            }
        });
    }else{
         var nextv = $(this).nextAll(":checkbox");
        //循环每一个前面的复选框，判断是否是上级权限
        $(nextv).each(function(k, v){
            //判断
            if($(v).attr("level") > cur_level){
                $(v).removeAttr("checked");
            }else{
                return false;
            }
        });
    }
});
</script>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>