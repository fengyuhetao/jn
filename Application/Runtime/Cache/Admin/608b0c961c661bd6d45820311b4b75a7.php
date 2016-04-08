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
    <form name="main_form" method="POST" action="/jn/index.php/Admin/Goods/edit/id/4.html" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>" />
        <input type="hidden" name="old_type_id" value="<?php echo ($data["id"]); ?>">
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td class="label">商品名称：</td>
                <td>
                    <input  type="text" name="goods_name" value="<?php echo $data['goods_name']; ?>" /><span style="color: red">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">商品主分类：</td>
                <td>
                    <select name="cate_id">
                        <option value="">请选择类型</option>
                        <?php foreach ($catData as $k => $v): ?>
                            <?php  if($data['cate_id'] == $v['id']) $selected = "selected='selected'"; else $selected = ""; ?>
                            <option value="<?php echo ($v["id"]); ?>" <?php echo $selected; ?>><?php echo str_repeat('-', $v['level']*8); echo ($v["cate_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                    <span style="color: red">*</span>
                </td>
            </tr>
            <tr>
                <td class="label">扩展分类</td>
                <td>
                    <input type="button" value="添加" onclick="$(this).parent().append($(this).next('select').clone());">
                    <?php if ($gcData): ?>
                        <?php foreach ($gcData as $k1 => $v1): ?>
                        <select name="extend_cate_id[]">
                            <option value="">选择分类</option>
                            <?php foreach ($catData as $k => $v): if ($v1['cate_id'] == $v['id']) { $selected = "selected='selected'"; } else{ $selected = ""; } ?>
                                <option <?php echo ($selected); ?> value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-', $v['level']*8); echo ($v["cate_name"]); ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php endforeach ?>
                    <?php else: ?>
                        <select name="extend_cate_id[]">
                        <option value="">选择分类</option>
                        <?php foreach ($catData as $k => $v): ?>
                            <option value="<?php echo ($v["id"]); ?>"><?php echo str_repeat('-', $v['level']*8); echo ($v["cate_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td class="label">商品品牌：</td>
                <td>
                    <select name="brand_id">
                        <option value="">请选择品牌</option>
                        <?php foreach ($brandData as $k => $v): ?>
                            <?php  if($data['brand_id'] == $v['id']) $selected = "selected='selected'"; else $selected = ""; ?>
                            <option value="<?php echo ($v["id"]); ?>" <?php echo $selected; ?>><?php echo ($v["brand_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">商品logo：</td>
                <td>
                    <input type="file" name="logo"/><br/>
                    <?php showImage($data['logo'], 100);?>
                </td>
            </tr>
            <tr>
                <td class="label">市场商品价格：</td>
                <td>
                    ￥<input  type="text" size="10" name="market_price" value="<?php echo $data['market_price']; ?>" />元
                </td>
            </tr>
            <tr>
                <td class="label">本店商品价格：</td>
                <td>
                    ￥<input  type="text" size="10" name="shop_price" value="<?php echo $data['shop_price']; ?>" />元
                </td>
            </tr>
            <tr>
                <td class="label">赠送积分：</td>
                <td>
                    <input  type="text" name="jifen" value="<?php echo $data['jifen']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">赠送经验值：</td>
                <td>
                    <input  type="text" name="jyz" value="<?php echo $data['jyz']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">如果要用积分兑换,需要的积分数,0代表不能用积分兑换：</td>
                <td>
                    <input  type="text" name="jifen_price" value="<?php echo $data['jifen_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label"><input type="checkbox" <?php if($data['is_promote']>0) echo 'checked="checked"';?> value="<?php echo $data['promote_price']; ?>" name="is_promote" onclick="if($(this).attr('checked')) $('.promote_price').removeAttr('disabled');else $('.promote_price').attr('disabled', true);">促销价：</td>
                <td>
                    <input <?php if($data['is_promote'] == 0) echo 'disabled="disabled"';?> class="promote_price"  type="text" name="promote_price" value="<?php echo $data['promote_price']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">促销开始时间：</td>
                <td>
                    <input class="promote_price" <?php if($data['is_promote'] == 0) echo 'disabled="disabled"';?> id="promote_start_time" type="text" name="promote_start_time" value="<?php if($data['promote_start_time'] != 1970) echo date('Y-m-d',$data['promote_start_time']); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">促销结束时间：</td>
                <td>
                    <input class="promote_price" <?php if($data['is_promote'] == 0) echo 'disabled="disabled"';?> id="promote_end_time" type="text" name="promote_end_time" value="<?php if($data['promote_end_time'] != 1970) echo date('Y-m-d',$data['promote_end_time']); ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否热卖：</td>
                <td>
                    <input type="radio" name="is_hot" value="1" <?php if($data['is_hot'] == 1) echo "checked='checked'"; ?> />是 
                    <input type="radio" name="is_hot" value="0" <?php if($data['is_hot'] == 0) echo "checked='checked'"; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否新品：</td>
                <td>
                    <input type="radio" name="is_new" value="1" <?php if($data['is_new'] == 1) echo "checked='checked'"; ?> />是 
                    <input type="radio" name="is_new" value="0" <?php if($data['is_new'] == 0) echo "checked='checked'"; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">是否精品：</td>
                <td>
                    <input type="radio" name="is_best" value="1" <?php if($data['is_best'] == 1) echo "checked='checked'"; ?> />是 
                    <input type="radio" name="is_best" value="0" <?php if($data['is_best'] == 0) echo "checked='checked'"; ?> />否 
                </td>
            </tr>
            <tr>
                <td class="label">seo_关键字：</td>
                <td>
                    <input  type="text" name="seo_keyword" value="<?php echo $data['seo_keyword']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">seo_描述：</td>
                <td>
                    <input  type="text" name="seo_description" value="<?php echo $data['seo_description']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">排序数字：</td>
                <td>
                    <input  type="text" name="sort_num" value="<?php echo $data['sort_num']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="label">是否上架:</td>
                <td>
                    <input type="radio" name="is_on_sale" value="1" <?php if($data['is_on_sale'] == 1) echo " checked='checked'"; ?> />上架 
                    <input type="radio" name="is_on_sale" value="0" <?php if($data['is_on_sale'] == 0) echo " checked='checked'"; ?> />下架 
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
                    <textarea id="goods_desc" name="goods_desc"><?php echo $data['goods_desc']; ?></textarea>
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
                    <td>￥<input type="text" name="mp[<?php echo ($v["id"]); ?>]" size="10" value="<?php echo ($memberPriceData[$v['id']]); ?>" />元</td>
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
                        <?php foreach ($typeData as $k => $v): if($v['id'] == $data['type_id']) $select = "selected='selected'"; else $select = ""; ?>
                            <option value="<?php echo ($v["id"]); ?>" <?php echo $select;?>><?php echo ($v["type_name"]); ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td id="attr_container">
                <?php  $attrId = array(); foreach ($gaData as $k => $v): ?>
                    <p>
                        <?php echo $v['attr_name']; ?>:
                        <?php if ($v['attr_type'] == 1): if(in_array($v['attr_id'], $attrId)) $opt = '-'; else { $opt = '+'; $attrId[] = $v['attr_id']; } ?>
                        <a gaid="<?php echo ($v["id"]); ?>" onclick="addnew(this);" href="javascript:void(0)">[<?php echo ($opt); ?>]</a>                
                        <?php endif ?>
                        <?php  $old = ''; if(empty($v['attr_value'])) $old = ''; else $old = 'old_'; if($v['attr_option_values']) { $option = explode(',', $v['attr_option_values']); echo "<select name='".$old."ga[".$v['attr_id']."][".$v['id']."]'><option value=''>请选择</option>"; foreach ($option as $k1 => $v1) { if($v1 == $v['attr_value']) { $selected = "selected='selected'"; } else $selected = ""; echo "<option ".$selected." value=".$v1.">".$v1."</option>" ; } echo "</select>"; } else { echo "<input type='text' name='".$old."ga[".$v['attr_id']."]' value='".$v['attr_value']."'"; } ?>
                        <?php if ($v['attr_type'] == 1): ?>
                            属性价格￥<input type="text" value="<?php echo ($v['attr_price']); ?>" name="<?php echo ($old); ?>attr_price[<?php echo ($v["attr_id"]); ?>][<?php echo ($v["id"]); ?>]" />元
                        <?php endif ?>
                    </p>
                <?php endforeach ?>
                </td>
            </tr>
        </table>
        <!-- 商品相册 -->
        <table class="table_content" cellspacing="1" cellpadding="3" width="100%" style="display:none">
            <tr>
                <td><input onclick="$(this).parent().parent().parent().append('<tr><td><input type=\'file\' name=\'pics[]\' /></td></tr>');" type="button" value="添加一张图片"></td>
            </tr>
            <tr>
                <td>
                    <ul id="pics_ul" style="list-style: none">
                        <?php foreach ($gpData as $k => $v): ?>
                            <li style="margin-bottom: 10px;">
                                <input pic_id="<?php echo ($v["id"]); ?>" type="button" class="delimage" value="删除">    
                                <?php showImage($v['sm_pic'], 100);?>
                            </li>   
                        <?php endforeach ?>
                    </ul>  
                </td>
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
        //找到select的name
        var oldSelectName = newP.find("select").attr("name");
        //把名字中的old_去掉
        oldSelectName = oldSelectName.replace("old_", "");
        newP.find("select").attr("name", oldSelectName);
        //找到input的name
        var oldInputName = newP.find("input").attr("name");
        //把名字中的old_去掉
        oldInputName = oldInputName.replace("old_", "");
        newP.find("input").attr("name", oldInputName);
        //把克隆出来的p里面的a标签变成-号,放在后面
        newP.find("a").html("[-]");
        p.after(newP);
    }
    else
    {
        //先获取要删除的记录的ID
        var gaid = $(a).attr('gaid');
        if(confirm("确定要删除吗?"))
        {
            $.get("<?php echo U('ajaxDelGoodsAttr', '', FALSE);?>/gaid/"+gaid,function(data){
                p.remove();
            });
        }
    } 
}

$(".delimage").click(function (){
    if(confirm("确定删除吗?"))
    {
        var pic_id = $(this).attr("pic_id");
        var li = $(this).parent();
        $.ajax({
            type : "GET",
            url : "<?php echo U('ajaxDelImage', '', FALSE); ?>/pic_id/"+pic_id,
            success : function(data){
                li.remove();
            }
        });
    }
});

//使用datepicker插件
$("#promote_start_time").datepicker(); 
$("#promote_end_time").datepicker(); 

//使用uEditor插件
UE.getEditor('goods_desc', {
    "initialFrameWidth" : "100%",   // 宽
    "initialFrameHeight" : 320,      // 高
    "maximumWords" : 10000            // 最大可以输入的字符数量
});

// 如果$gaData的数据为空,触发change事件
<?php if(!$gaData) : ?>
// $("select[name=type_id]").change();
$("select[name=type_id]").trigger("change");
<?php endif; ?>
</script>

<div id="footer">
共执行 3 个查询，用时 0.021251 秒，Gzip 已禁用，内存占用 2.194 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。
</div>

<script type="text/javascript" charset="utf-8" src="/jn/Public/Admin/Js/tron.js"></script>