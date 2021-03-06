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

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >基本信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Goods/add.html" enctype="multipart/form-data">
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称：</td>
                <td>
                    <input  type="text" name="goods_name" value="" /><span style="color: red">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品主分类：</td>
                <td>
                    <select name="cate_id">
                        <option value="">请选择类型</option>
                        <?php foreach ($catData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-', $v['level']*8); echo ($v["cate_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                    <span style="color: red">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">扩展分类</td>
                <td>
                    <input type="button" value="添加" onclick="$(this).parent().append($(this).next('select').clone());">
                    <select name="extend_cate_id[]">
                        <option value="">选择分类</option>
                        <?php foreach ($catData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-', $v['level']*8); echo ($v["cate_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">商品品牌：</td>
                <td>
                    <select name="brand_id">
                        <option value="">请选择品牌</option>
                        <?php foreach ($brandData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["brand_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">商品logo：</td>
                <td>
                	<input type="file" name="logo" /> 
                </td>
            </tr>
            <tr>
                <td class="label">市场商品价格：</td>
                <td>
                    ￥<input  type="text" size="10" name="market_price" value="0.00" />元
                </td>
            </tr>
            <tr>
                <td class="label">本店商品价格：</td>
                <td>
                    ￥<input  type="text" size="10" name="shop_price" value="0.00" />元
                </td>
            </tr>
            <tr>
                <td class="label">赠送积分：</td>
                <td>
                    <input  type="text" name="jifen" value="0" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送经验值：</td>
                <td>
                    <input  type="text" name="jyz" value="0" />
                </td>
            </tr>
            <tr>
                <td class="label">如果要用积分兑换,需要的积分数,0代表不能用积分兑换：</td>
                <td>
                    <input  type="text" name="jifen_price" value="0" />
                </td>
            </tr>
            <tr>
                <td class="label"><input type="checkbox" value="1" name="is_promote" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled', true);">促销价：</td>
                <td>
                    <input disabled="disabled" class="promote_price"  type="text" name="promote_price" value="0.00" />
                </td>
            </tr>
            <tr>
                <td class="label">促销开始时间：</td>
                <td>
                    <input class="promote_price" disabled="disabled" id="promote_start_time" type="text" name="promote_start_time" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">促销结束时间：</td>
                <td>
                    <input class="promote_price" disabled="disabled" id="promote_end_time" type="text" name="promote_end_time" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">是否热卖：</td>
                <td>
                	<input type="radio" name="is_hot" value="1"  />是 
                	<input type="radio" name="is_hot" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否新品：</td>
                <td>
                	<input type="radio" name="is_new" value="1"  />是 
                	<input type="radio" name="is_new" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否精品：</td>
                <td>
                	<input type="radio" name="is_best" value="1"  />是 
                	<input type="radio" name="is_best" value="0" checked="checked" />否 
                </td>
            </tr>
            <tr>
                <td class="label">seo_关键字：</td>
                <td>
                    <input  type="text" name="seo_keyword" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">seo_描述：</td>
                <td>
                    <input  type="text" name="seo_description" value="" />
                </td>
            </tr>
            <tr>
                <td class="label">排序数字：</td>
                <td>
                    <input  type="text" name="sort_num" value="100" />
                </td>
            </tr>
            <tr>
                <td class="label">是否上架:</td>
                <td>
                	<input type="radio" name="is_on_sale" value="1" checked="checked" />上架 
                	<input type="radio" name="is_on_sale" value="0"  />下架 
                </td>
            </tr>
        </table>

        <!-- 商品描述 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
            <tr>
                <td class="label" style="text-align: left">商品描述：</td>
            </tr>
            <tr>
                <td>
                    <textarea id="goods_desc" name="goods_desc"></textarea>
                </td>
            </tr>
        </table>
        <!-- 会员价格 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
            <tr>
                <td>会员价格(如果没有设置会员价格,就按折扣率计算价格)</td>
            </tr>
            <?php foreach ($memberLevelData as $k => $v): ?>
                <tr>
                    <td><?php echo ($v["level_name"]); ?><span>[<?php echo $v['rate']/10; ?>折]</span></td>
                    <td>￥<input type="text" name="mp[<?php echo ($v["id"]); ?>]" size="10" value="0.00" />元</td>
                </tr>
            <?php endforeach ?>
        </table>
        <!-- 商品属性 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
            <tr>
                <td class="label">商品属性</td>
                <td>
                    <select name="type_id">
                        <option value="">选择类型</option>
                        <?php foreach ($typeData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>"><?php echo ($v["type_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr><td id="attr_container"></td></tr>
        </table>
        <!-- 商品相册 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
            <tr>
                <td><input onclick="$(this).parent().parent().parent().append('<tr><td><input type=\'file\' name=\'pics[]\' /></td></tr>');" type="button" value="添加一张图片"></td>
            </tr>
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
</div>
<script>
//点击按钮切换表格
$("div#tabbar-div p span").click(function (){
    //获取点击的是第几个按钮
    var i = $(this).index();
    var _this = $(this);
    $("div#tabbar-div p span").each(function (){
        $(this).attr('class', 'tab-back');
    });
    $("table.table_content").each(function (){
        $(this).hide();
    })
    $("table.table_content").eq(i).show();
    // $("table.table_content").eq(i).siblings().hide();
    _this.attr('class', 'tab-front');
});

//当选择类型是，执行ajax显示类型的属性
$("select[name=type_id]").change(function (){
    $("#attr_container").html("");
    var type_id = $(this).val();
    if(type_id != "")
    {
        $.ajax({
            type : "GET",
            //第三个参数去掉.html后缀，否则报错
            url : "<?php echo U('ajaxGetAttr', '', FALSE);?>/type_id/"+type_id,
            dataType : "json",
            success : function(data){
                var html = "";
                $.each(data, function(k, v){
                    html += "<p>";
                    html += v.attr_name + " : ";
                   
                    //根据属性的类型生成不同的表单元素
                    //1.如果属性是可选的,就有一个+号
                    //2.如果属性有可选值就做成下拉框
                    //3.如果属性是唯一的就生成一个文本框
                    if(v.attr_type == 1)
                    {
                        html += " <a onclick='addnew(this);' href='javascript:void(0);'>[+]</a> ";
                    }
                    //判断是否有可选值
                    if(v.attr_option_values == "")
                    {
                        html += "<input type='text' name='ga["+v.id+"]'/>";
                    }
                    else
                    {
                       var _attr = v.attr_option_values.split(',');
                       html += "<select name='ga["+v.id+"][]'>";
                       html += "<option value=\"\">请选择</option>";
                       //循环构造option
                       for(var i = 0; i < _attr.length; i++){
                            html += "<option value='" + _attr[i] + "'>" + _attr[i] + "</option>";
                       }
                       html += "</select>"; 
                    }
                    if(v.attr_type == 1)
                    {
                        html +="属性价格￥<input size='10' name='attr_price["+v.id+"][]' type='text'/>元"
                    }
                    html += "</p>";
                    $("#attr_container").html(html);
                });
            }
        });
    }
});

/**
 * 点击a标签后复制一个新的该标签
 */
function addnew(a){
    var p = $(a).parent();
    //先获取a标签中的内容
    if($(a).html() == "[+]")
    {
        //把p克隆一份
        var newP = p.clone();
        //把克隆出来的p里面的a标签变成-号,放在后面
        newP.find("a").html("[-]");
        p.after(newP);
    }
    else
    {
        p.remove();
    }
    
}

//使用datepicker插件
$("#promote_start_time").datepicker(); 
$("#promote_end_time").datepicker(); 

//使用uEditor插件
UE.getEditor('goods_desc', {
	"initialFrameWidth" : "100%",   // 宽
	"initialFrameHeight" : 320,      // 高
	"maximumWords" : 10000            // 最大可以输入的字符数量
});
</script>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>