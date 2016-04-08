/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

/**
 * 扩展:
 * var a = 0.95;
 * var b = 0.37;
 * alert(a+b);
 * 结果并不是1.32,而是1.3199999999
 * alert((a+b).toFixed(2))
 */

$(function(){
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
			//获取所在tr
			var tr = $(this).parent().parent();
			var gid = tr.attr('goods_id');
			var gaid = tr.attr("goods_attr_str");
			//执行ajax更新到服务器
			//如果点击速率过快,改短该段代码可能回来不及执行，造成显示结果和数据库不一致？该如何解决
			ajaxUpdateCartData(gid, gaid, $(amount).val());
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//增加
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		$(amount).val(parseInt($(amount).val()) + 1);
		//获取所在tr
		var tr = $(this).parent().parent();
		var gid = tr.attr('goods_id');
		var gaid = tr.attr("goods_attr_str");
		//执行ajax更新到服务器
		ajaxUpdateCartData(gid, gaid, $(amount).val());
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));

	});

	$(".col6 a").click(function(){
		//先取所在的tr
		if(confirm("are you sure?"))
		{	
			var tr = $(this).parent().parent();
			var gid = tr.attr('goods_id');
			var gaid = tr.attr("goods_attr_str");
			ajaxUpdateCartData(gid, gaid, 0);
			tr.remove();
			//总计金额
			var total = 0;
			$(".col5 span").each(function(){
				total += parseFloat($(this).text());
			});

			$("#total").text(total.toFixed(2));
		}
		return false;
	});
});
