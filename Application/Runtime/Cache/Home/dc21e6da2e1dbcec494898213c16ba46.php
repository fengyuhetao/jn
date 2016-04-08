<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta />
	<title><?php echo ($page_title); ?></title>
	<link rel="stylesheet" href="/jn/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/jn/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/jn/Public/Home/style/header.css" type="text/css">

	<?php foreach ($page_css as $k => $v): ?>
		<link rel="stylesheet" href="/jn/Public/Home/style/<?php echo ($v); ?>.css" type="text/css">
	<?php endforeach ?>

	<link rel="stylesheet" href="/jn/Public/Home/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/jn/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/jn/Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/jn/Public/Home/js/header.js"></script>
	
	<?php foreach ($page_js as $k => $v): ?>
		<script type="text/javascript" src="/jn/Public/Home/js/<?php echo ($v); ?>.js"></script>
	<?php endforeach ?>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<li id="loginInfo">
					<?php  if (session('id') >= 0 && !is_null(session('id'))): ?>
						您好<?php echo session('email');?>！[<a href="<?php echo U('Home/Member/logout') ?>">退出</a>]
					<?php else: ?>
						您好，欢迎来到京西！[<a href="<?php echo U('Home/Member/login') ?>">登录</a>] [<a href="<?php echo U('Home/Member/regist') ?>">免费注册</a>] </li>
					<?php endif ?>
					<li class="line">|</li>
					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 内容 -->
	

<?php  $catModel = D('Admin/Category'); $catData = $catModel->getNavCatData(); ?>
<!-- 头部 start -->
	<div class="header w1210 bc mt15">
		<!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
		<div class="logo w1210">
			<h1 class="fl"><a href="<?php echo U('Home/Index/index'); ?>"><img src="./Public/Home/images/logo.png" alt="京西商城"></a></h1>
			<!-- 头部搜索 start -->
			<div class="search fl">
				<div class="search_form">
					<div class="form_left fl"></div>
					<form action="" name="serarch" method="get" class="fl">
						<input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
					</form>
					<div class="form_right fl"></div>
				</div>
				
				<div style="clear:both;"></div>

				<div class="hot_search">
					<strong>热门搜索:</strong>
					<a href="">D-Link无线路由</a>
					<a href="">休闲男鞋</a>
					<a href="">TCL空调</a>
					<a href="">耐克篮球鞋</a>
				</div>
			</div>
			<!-- 头部搜索 end -->

			<!-- 用户中心 start-->
			<div class="user fl">
				<dl>
					<dt>
						<em></em>
						<a href="">用户中心</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							您好，请<a href="">登录</a>
						</div>
						<div class="uclist mt10">
							<ul class="list1 fl">
								<li><a href="">用户信息></a></li>
								<li><a href="">我的订单></a></li>
								<li><a href="">收货地址></a></li>
								<li><a href="">我的收藏></a></li>
							</ul>

							<ul class="fl">
								<li><a href="">我的留言></a></li>
								<li><a href="">我的红包></a></li>
								<li><a href="">我的评论></a></li>
								<li><a href="">资金管理></a></li>
							</ul>

						</div>
						<div style="clear:both;"></div>
						<div class="viewlist mt10">
							<h3>最近浏览的商品：</h3>
							<ul id="recent_display"></ul>
						</div>
					</dd>
				</dl>
			</div>
			<!-- 用户中心 end-->

			<!-- 购物车 start -->
			<div class="cart fl">
				<dl>
					<dt>
						<a target="_blank" href="<?php echo U('Home/Cart/lst');?>">去购物车结算</a>
						<b></b>
					</dt>
					<dd>
						<div class="prompt">
							购物车中还没有商品，赶紧选购吧！
						</div>
					</dd>
				</dl>
			</div>
			<!-- 购物车 end -->
		</div>
		<!-- 头部上半部分 end -->
		
		<div style="clear:both;"></div>

		<!-- 导航条部分 start -->
		<div class="nav w1210 bc mt10">
			<!--  商品分类部分 start-->
			<div class="category fl <?php if($nav != 1) echo 'cat1'; ?>"> <!-- 非首页，需要添加cat1类 -->
				<div class="cat_hd <?php if($nav != 1) echo 'off'; ?>">  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
					<h2>全部商品分类</h2>
					<em></em>
				</div>
				
				<div class="cat_bd">
				<!-- 循环顶级分类 -->
				<?php foreach ($catData as $k => $v):?>
					<div class="cat <?php if($k == 0) echo 'item1'; ?>">	
						<h3><a href="<?php echo U('Home/Search/search?cid='.$v['id']);?>"><?php echo ($v["cate_name"]); ?></a> <b></b></h3>
						<div class="cat_detail">
						<!-- 循环二级分类 -->
						<?php foreach ($v['children'] as $k1 => $v1): ?>
							<dl class="dl_1st">
								<dt><a href="<?php echo U('Home/Search/search?cid='.$v1['id']);?>"><?php echo ($v1['cate_name']); ?></a></dt>
								<dd>
								<!-- 循环三级分类 -->
								<?php foreach ($v1['children'] as $k2 => $v2): ?>
									<a href="<?php echo U('Home/Search/search?cid='.$v2['id']);?>"><?php echo ($v2["cate_name"]); ?></a>	
								<?php endforeach ?>
								</dd>
							</dl>
						<?php endforeach ?>								
						</div>
					</div>	
				<?php endforeach ?>
				</div>

			</div>
			<!--  商品分类部分 end--> 

			<div class="navitems fl">
				<ul class="fl">
					<li class="current"><a href="">首页</a></li>
					<li><a href="">电脑频道</a></li>
					<li><a href="">家用电器</a></li>
					<li><a href="">品牌大全</a></li>
					<li><a href="">团购</a></li>
					<li><a href="">积分商城</a></li>
					<li><a href="">夺宝奇兵</a></li>
				</ul>
				<div class="right_corner fl"></div>
			</div>
		</div>
		<!-- 导航条部分 end -->
	</div>
	<!-- 头部 end-->
	
	<div style="clear:both;"></div>

	<script type="text/javascript">
	var img_url = "<?php echo C('IMG_rootPath'); ?>";
	$.ajax({
		type : "GET",
		url : "<?php echo U('Home/Index/ajaxGetRecentDisGoods'); ?>",
		dataType : "JSON",
		success : function (data)
		{
			var str = '';
			//显示在页面上
			$(data).each(function(k, v){
				str += '<li><a href="<?php echo U('Home/Index/Goods', '', FALSE);?>/id/"'+v.id+'?><img src="'+img_url+v.sm_logo+'" alt="" /></a></li>'; 
			});
			$("#recent_display").html(str);
		}
	});
	</script>

	<!-- 列表主体 start -->
	<div class="list w1210 bc mt10">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a></h2>
		</div>
		<!-- 面包屑导航 end -->

		<!-- 左侧内容 start -->
		<div class="list_left fl mt10">
			<!-- 分类列表 start -->
			<div class="catlist">
				<h2>电脑、办公</h2>
				<div class="catlist_wrap">
					<div class="child">
						<h3 class="on"><b></b>电脑整机</h3>
						<ul>
							<li><a href="">笔记本</a></li>
							<li><a href="">超极本</a></li>
							<li><a href="">平板电脑</a></li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>电脑配件</h3>
						<ul class="none">
							<li><a href="">CPU</a></li>
							<li><a href="">主板</a></li>
							<li><a href="">显卡</a></li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>办公打印</h3>
						<ul class="none">
							<li><a href="">打印机</a></li>
							<li><a href="">一体机</a></li>
							<li><a href="">投影机</a></li>
							</li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>网络产品</h3>
						<ul class="none">
							<li><a href="">路由器</a></li>
							<li><a href="">网卡</a></li>
							<li><a href="">交换机</a></li>
							</li>
						</ul>
					</div>

					<div class="child">
						<h3><b></b>外设产品</h3>
						<ul class="none">
							<li><a href="">鼠标</a></li>
							<li><a href="">键盘</a></li>
							<li><a href="">U盘</a></li>
						</ul>
					</div>
				</div>
				
				<div style="clear:both; height:1px;"></div>
			</div>
			<!-- 分类列表 end -->
				
			<div style="clear:both;"></div>	

			<!-- 新品推荐 start -->
			<div class="newgoods leftbar mt10">
				<h2><strong>新品推荐</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/list_hot1.jpg" alt="" /></a></dt>
								<dd><a href="">美即流金丝语悦白美颜新年装4送3</a></dd>
								<dd><strong>￥777.50</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/list_hot2.jpg" alt="" /></a></dt>
								<dd><a href="">领券满399减50 金斯利安多维片</a></dd>
								<dd><strong>￥239.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/list_hot3.jpg" alt="" /></a></dt>
								<dd><a href="">皮尔卡丹pierrecardin 男士长...</a></dd>
								<dd><strong>￥1240.50</strong></dd>
							</dl>
						</li>
					</ul>
				</div>
			</div>
			<!-- 新品推荐 end -->

			<!--热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!--热销排行 end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap">
					<dl>
						<dt><a href=""><img src="/jn/Public/Home/images/hpG4.jpg" alt="" /></a></dt>
						<dd><a href="">惠普G4-1332TX 14英寸笔记...</a></dd>
					</dl>

					<dl class="last">
						<dt><a href=""><img src="/jn/Public/Home/images/crazy4.jpg" alt="" /></a></dt>
						<dd><a href="">直降200元！TCL正1.5匹空调</a></dd>
					</dl>
				</div>
			</div>
			<!-- 最近浏览 end -->
		</div>
		<!-- 左侧内容 end -->
	
		<!-- 列表内容 start -->
		<div class="list_bd fl ml10 mt10">
			<!-- 热卖、促销 start -->
			<div class="list_top">
				<!-- 热卖推荐 start -->
				<div class="hotsale fl">
					<h2><strong><span class="none">热卖推荐</span></strong></h2>
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/hpG4.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">惠普G4-1332TX 14英寸笔记本电脑 （i5-2450M 2G 5</a></dd>
								<dd class="price">特价：<strong>￥2999.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/list_hot3.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">ThinkPad E42014英寸笔记本电脑</a></dd>
								<dd class="price">特价：<strong>￥4199.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/acer4739.jpg" alt="" /></a></dt>
								<dd class="name"><a href="">宏碁AS4739-382G32Mnkk 14英寸笔记本电脑</a></dd>
								<dd class="price">特价：<strong>￥2799.00</strong></dd>
								<dd class="buy"><span>立即抢购</span></dd>
							</dl>
						</li>
					</ul>
				</div>
				<!-- 热卖推荐 end -->

				<!-- 促销活动 start -->
				<div class="promote fl">
					<h2><strong><span class="none">促销活动</span></strong></h2>
					<ul>
						<li><b>.</b><a href="">DIY装机之向雷锋同志学习！</a></li>
						<li><b>.</b><a href="">京东宏碁联合促销送好礼！</a></li>
						<li><b>.</b><a href="">台式机笔记本三月巨惠！</a></li>
						<li><b>.</b><a href="">富勒A53g智能人手识别鼠标</a></li>
						<li><b>.</b><a href="">希捷硬盘白色情人节专场</a></li>
					</ul>

				</div>
				<!-- 促销活动 end -->
			</div>
			<!-- 热卖、促销 end -->
			
			<div style="clear:both;"></div>
			<a name="search"></a>
			<!-- 商品筛选 start -->
			<div class="filter mt10">
				<h2><a href="">重置筛选条件</a> <strong>商品筛选</strong></h2>
				<div class="filter_wrap">
				<?php
 foreach ($attrData as $k => $v): ?>
					<dl>
						<dt><?php echo ($v["attr_name"]); ?>：</dt>
						<dd class="cur"><a href="<?php echo U('search?cid='.I('get.cid').'&price='.I('get.price'));?>">不限</a></dd>
						<?php  $attrDataCount = count($attrData); $sa = I('get.search_attr'); if($sa) $_attr_str = explode('.', $sa); else $_attr_str = array_fill(0, $attrDataCount, 0); foreach ($v['attr_value'] as $k1 => $v1): $_tmp_attr_str = $_attr_str; $_tmp_attr_str[$k] = $v1['attr_value'].'-'.$v['id']; ?>
							<dd class=""><a href="<?php echo U('search?cid='.I('get.cid').'&price='.I('get.price').'&search_attr='.implode('.', $_tmp_attr_str));?>"><?php echo ($v1["attr_value"]); ?></a></dd>
						<?php endforeach ?>
					</dl>
				<?php endforeach ?>
					<dl>
						<dt>价格：</dt>	
						<dd <?php if(!I('get.price')) echo 'class="cur"';?> ><a href="<?php echo U('search?cid='.I('get.cid'));?>#search">不限</a></dd>
					<?php foreach ($price as $k => $v): ?>
						<dd <?php if(I('get.price') == $v) echo 'class="cur"';?>><a href="<?php echo U('search?cid='.I('get.cid').'&price='.$v.'&search_attr='.I('get.search_attr'));?>#search"><?php echo ($v); ?></a></dd>
					<?php endforeach ?>
					</dl>							
				</div>
			</div>
			<!-- 商品筛选 end -->
			
			<div style="clear:both;"></div>

			<!-- 排序 start -->
			<div class="sort mt10">
				<dl>
					<dt>排序：</dt>
					<dd <?php if(I('get.ob', 'xl') == 'xl') echo 'class="cur"'; ?>><a href="<?php echo U('search?cid='.I('get.cid').'&ob=xl&price='.I('get.price').'&shop_price='.I('get_price')); ?>">销量</a></dd>
					<dd <?php if(I('get.ob') == 'shop_price') echo 'class="cur"'; ?>>
						<a href="<?php echo U('search?cid='.I('get.cid').'&ob=shop_price&ow='.(I('get.ow') == 'desc' ? 'asc' : 'desc').'&price='.I('get.price').'&shop_price='.I('get_price')); ?>">价格<?php if(I('get.ow') == '' || I('get.ow') == 'desc') echo '[降]'; else echo '[升]';?>
						</a>
					</dd>
					<dd <?php if(I('get.ob') == 'pl') echo 'class="cur"'; ?>><a href="<?php echo U('search?cid='.I('get.cid').'&ob=pl&price='.I('get.price').'&shop_price='.I('get_price')) ?>">评论数</a></dd>
					<dd <?php if(I('get.ob') == 'addtime') echo 'class="cur"'; ?>><a href="<?php echo U('search?cid='.I('get.cid').'&ob=addtime&price='.I('get.price').'&shop_price='.I('get_price')); ?>">上架时间</a></dd>
				</dl>
			</div>
			<!-- 排序 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品列表 start-->
			<div class="goodslist mt10">
				<ul>
				<?php
 $rootPath = C('IMG_rootPath'); foreach ($goods_search['data'] as $k => $v): ?>
					<li>
						<dl>
							<dt><a href="<?php echo U('Home/Index/goods','', false).'/id/'.$v['id'];?>"><img src="<?php echo $rootPath.$v['sm_logo'];?>" alt="图片不存在" /></a></dt>
							<dd><a href="<?php echo U('Home/Index/goods/id/'.$v['id'],'', false);?>"><?php echo ($v["goods_name"]); ?></a></dt>
							<dd><strong>￥<?php echo ($v["shop_price"]); ?>元</strong></dt>已有<?php echo ($v["pl"]); ?>人评价</em> <em>销量：<?php echo ($v["xl"]); ?></em></a></dt>
						</dl>
					</li>
				<?php endforeach ?>
					

				</ul>
			</div>
			<!-- 商品列表 end-->
			<div class="page mt20">
			<?php if(preg_match('/\d/', $goods_search['page'])): ?>  
        		<tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $goods_search['page']; ?></td></tr>
	        <?php endif; ?>
	        </div>
			<!-- 分页信息 start -->
			<!-- <div class="page mt20">
				<a href="">首页</a>
				<a href="">上一页</a>
				<a href="">1</a>
				<a href="">2</a>
				<a href="" class="cur">3</a>
				<a href="">4</a>
				<a href="">5</a>
				<a href="">下一页</a>
				<a href="">尾页</a>&nbsp;&nbsp; 
				<span>
					<em>共8页&nbsp;&nbsp;到第 <input type="text" class="page_num" value="3"/> 页</em>
					<a href="" class="skipsearch" href="javascript:;">确定</a>
				</span>
			</div> -->
			<!-- 分页信息 end -->

		</div>
		<!-- 列表内容 end -->
	</div>
	<!-- 列表主体 end-->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/jn/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/jn/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/jn/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/jn/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>
<script type="text/javascript">
	//ajax判断登录状态
	$.ajax({
		type : "GET",
		url : "<?php echo U('Home/Member/ajaxChkLogin'); ?>",
		dataType : "json",
		success : function(data){
			var html = "";
			if(data.ok == 1)
				html += "您好, "+data.email+" [<a href='<?php echo U('Home/Member/logout');?>'>退出</a>]";
			else
				html += "您好，欢迎来到京西！[<a href='<?php echo U('Home/Member/login'); ?>'>登录</a>] [<a href='<?php echo U('Home/Member/regist'); ?>'>免费注册</a>]";
			$("#loginInfo").html(html);
		}
	});
</script>