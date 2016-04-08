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

<!-- jqzoom 效果 -->
	<script type="text/javascript">
		$(function(){
			$('.jqzoom').jqzoom({
	            zoomType: 'standard',
	            lens:true,
	            preloadImages: false,
	            alwaysOn:false,
	            title:false,
	            zoomWidth:400,
	            zoomHeight:400
	        });
		})
	</script>

<!-- 商品页面主体 start -->
	<div class="main w1210 mt10 bc">
		<!-- 面包屑导航 start -->
		<div class="breadcrumb">
			<h2>当前位置：<a href="">首页</a> > <a href="">电脑、办公</a> > <a href="">笔记本</a> > ThinkPad X230(23063T4）12.5英寸笔记本</h2>
		</div>
		<!-- 面包屑导航 end -->
		
		<!-- 主体页面左侧内容 start -->
		<div class="goods_left fl">
			<!-- 相关分类 start -->
			<div class="related_cat leftbar mt10">
				<h2><strong>相关分类</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">笔记本</a></li>
						<li><a href="">超极本</a></li>
						<li><a href="">平板电脑</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关分类 end -->

			<!-- 相关品牌 start -->
			<div class="related_cat	leftbar mt10">
				<h2><strong>同类品牌</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li><a href="">D-Link</a></li>
						<li><a href="">戴尔</a></li>
						<li><a href="">惠普</a></li>
						<li><a href="">苹果</a></li>
						<li><a href="">华硕</a></li>
						<li><a href="">宏基</a></li>
						<li><a href="">神舟</a></li>
					</ul>
				</div>
			</div>
			<!-- 相关品牌 end -->

			<!-- 热销排行 start -->
			<div class="hotgoods leftbar mt10">
				<h2><strong>热销排行榜</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
			<!-- 热销排行 end -->


			<!-- 浏览过该商品的人还浏览了  start 注：因为和list页面newgoods样式相同，故加入了该class -->
			<div class="related_view newgoods leftbar mt10">
				<h2><strong>浏览了该商品的用户还浏览了</strong></h2>
				<div class="leftbar_wrap">
					<ul>
						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/relate_view1.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E431(62771A7) 14英寸笔记本电脑 (i5-3230 4G 1TB 2G独显 蓝牙 win8)</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/relate_view2.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad X230i(2306-3V9） 12.5英寸笔记本电脑 （i3-3120M 4GB 500GB 7200转 蓝牙 摄像头 Win8）</a></dd>
								<dd><strong>￥5199.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/relate_view3.jpg" alt="" /></a></dt>
								<dd><a href="">T联想（Lenovo） Yoga13 II-Pro 13.3英寸超极本 （i5-4200U 4G 128G固态硬盘 摄像头 蓝牙 Win8）晧月银</a></dd>
								<dd><strong>￥7999.00</strong></dd>
							</dl>
						</li>

						<li>
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/relate_view4.jpg" alt="" /></a></dt>
								<dd><a href="">联想（Lenovo） Y510p 15.6英寸笔记本电脑（i5-4200M 4G 1T 2G独显 摄像头 DVD刻录 Win8）黑色</a></dd>
								<dd><strong>￥6199.00</strong></dd>
							</dl>
						</li>

						<li class="last">
							<dl>
								<dt><a href=""><img src="/jn/Public/Home/images/relate_view5.jpg" alt="" /></a></dt>
								<dd><a href="">ThinkPad E530c(33662D0) 15.6英寸笔记本电脑 （i5-3210M 4G 500G NV610M 1G独显 摄像头 Win8）</a></dd>
								<dd><strong>￥4399.00</strong></dd>
							</dl>
						</li>					
					</ul>
				</div>
			</div>
			<!-- 浏览过该商品的人还浏览了  end -->

			<!-- 最近浏览 start -->
			<div class="viewd leftbar mt10">
				<h2><a href="">清空</a><strong>最近浏览过的商品</strong></h2>
				<div class="leftbar_wrap" id="goods_recent_display">
				</div>
			</div>
			<!-- 最近浏览 end -->

		</div>
		<!-- 主体页面左侧内容 end -->
		
		<!-- 商品信息内容 start -->
		<div class="goods_content fl mt10 ml10">
			<!-- 商品概要信息 start -->
			<div class="summary">
				<h3><strong><?php echo ($info["goods_name"]); ?></strong></h3>
				<?php $rootPath = C('IMG_rootPath'); ?>
				<!-- 图片预览区域 start -->
				<div class="preview fl">
					<div class="midpic">
						<a href="<?php echo $rootPath.$info['logo']; ?>" class="jqzoom" rel="gal1">   <!-- 第一幅图片的大图 class 和 rel属性不能更改 -->
							<?php echo showImage($info['sm_logo'], 350); ?>               <!-- 第一幅图片的中图 -->
						</a>
					</div>
	
					<!--使用说明：此处的预览图效果有三种类型的图片，大图，中图，和小图，取得图片之后，分配到模板的时候，把第一幅图片分配到 上面的midpic 中，其中大图分配到 a 标签的href属性，中图分配到 img 的src上。 下面的smallpic 则表示小图区域，格式固定，在 a 标签的 rel属性中，分别指定了中图（smallimage）和大图（largeimage），img标签则显示小图，按此格式循环生成即可，但在第一个li上，要加上cur类，同时在第一个li 的a标签中，添加类 zoomThumbActive  -->

					<div class="smallpic">
						<a href="javascript:;" id="backward" class="off"></a>
						<a href="javascript:;" id="forward" class="on"></a>
						<div class="smallpic_wrap">
							<ul>
								<li class="cur">
									<a class="zoomThumbActive" href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $rootPath.$info['sm_logo']; ?>',largeimage: '<?php echo $rootPath.$info['logo']; ?>'}"><?php showImage($info['sm_logo']) ?></a>
								</li>
								<?php foreach ($picData as $k => $v): ?>
								<li>
									<a href="javascript:void(0);" rel="{gallery: 'gal1', smallimage: '<?php echo $rootPath.$v['sm_pic']; ?>',largeimage: '<?php echo $rootPath.$v['pic']; ?>'}"><?php showImage($v['sm_pic']) ?></a>
								</li>
								<?php endforeach ?>
							</ul>
						</div>
						
					</div>
				</div>
				<!-- 图片预览区域 end -->

				<!-- 商品基本信息区域 start -->
				<div class="goodsinfo fl ml10">
					<ul>
						<li><span>商品编号： </span><?php echo ($info["id"]); ?></li>
						<li class="market_price"><span>定价：</span><em>￥<?php echo ($info["market_price"]); ?></em></li>
						<li class="shop_price"><span>本店价：</span> <strong>￥<?php echo ($info["shop_price"]); ?></strong> <a href="">(降价通知)</a></li>
						<li><span>上架时间：</span><?php echo ($info["addtime"]); ?></li>
						<li class="star"><span>商品评分：</span> <strong></strong><a href="">(已有21人评价)
						</a></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
						<li><span>会员价格：</span><span id="memberPrice" style="font-size: 16px; font-weight: bold;"></span></li> <!-- 此处的星级切换css即可 默认为5星 star4 表示4星 star3 表示3星 star2表示2星 star1表示1星 -->
					</ul>
					<form target="_blank" action="<?php echo U('Home/Cart/add');?>" method="post" class="choose">
					<input type="hidden" name="goods_id" value="<?php echo ($info["id"]); ?>" />
						<ul>
						<?php foreach ($gaMultiData as $k => $v): ?>
							<li class="product">
								<dl>
									<dt><?php echo ($v['0']["attr_name"]); ?>：</dt>
									<dd>
									<?php foreach ($v as $k1 => $v1):?>
										<a <?php if($k1 == 0) echo 'class="selected"';?> href="javascript:;"><?php echo ($v1["attr_value"]); ?> <input type="radio" name="goods_attr_id[<?php echo ($v1["attr_id"]); ?>]" value="<?php echo ($v1["id"]); ?>" <?php if($k1 ==0 ) echo 'checked="checked"';?>/></a>
									<?php endforeach ?>
									</dd>
								</dl>
							</li>
						<?php endforeach ?>
							
							<li>
								<dl>
									<dt>购买数量：</dt>
									<dd>
										<a href="javascript:;" id="reduce_num"></a>
										<input type="text" name="goods_number" value="1" class="amount"/>
										<a href="javascript:;" id="add_num"></a>
									</dd>
								</dl>
							</li>

							<li>
								<dl>
									<dt>&nbsp;</dt>
									<dd>
										<input type="submit" value="" class="add_btn" />
									</dd>
								</dl>
							</li>

						</ul>
					</form>
				</div>
				<!-- 商品基本信息区域 end -->
			</div>
			<!-- 商品概要信息 end -->
			
			<div style="clear:both;"></div>

			<!-- 商品详情 start -->
			<div class="detail">
				<div class="detail_hd">
					<ul>
						<li class="first"><span>商品介绍</span></li>
						<li class="on"><span>商品评价</span></li>
						<li><span>售后保障</span></li>
					</ul>
				</div>
				<div class="detail_bd">
					<!-- 商品介绍 start -->
					<div class="introduce detail_div none">
						<div class="attr mt15">
							<ul>
							<?php foreach ($gaSingleData as $k => $v): ?>
								<li><span><?php echo ($v["attr_name"]); ?>：</span><?php echo ($v["attr_value"]); ?></li>
							<?php endforeach ?>
							</ul>
						</div>

						<div class="desc mt10">
							<!-- 此处的内容 一般是通过在线编辑器添加保存到数据库，然后直接从数据库中读出 -->
							<!-- <img src="/jn/Public/Home/images/desc1.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc2.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc3.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc4.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc5.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc6.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc7.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc8.jpg" alt="" />
							<p style="height:10px;"></p>
							<img src="/jn/Public/Home/images/desc9.jpg" alt="" /> -->
							<?php echo $info['goods_desc']; ?>
						</div>
					</div>
					<!-- 商品介绍 end -->
					
					<!-- 商品评论 start -->
					<div class="comment detail_div mt10">
						<div class="comment_summary">
							<div class="rate fl">
								<strong><em>90</em>%</strong> <br />
								<span>好评度</span>
							</div>
							<div class="percent fl">
								<dl>
									<dt>好评（90%）</dt>
									<dd><div style="width:90px;"></div></dd>
								</dl>
								<dl>
									<dt>中评（5%）</dt>
									<dd><div style="width:5px;"></div></dd>
								</dl>
								<dl>
									<dt>差评（5%）</dt>
									<dd><div style="width:5px;" ></div></dd>
								</dl>
							</div>
							<div class="buyer fl">
								<dl>
									<dt>买家印象：</dt>
									<dd><span>屏幕大</span><em>(1953)</em></dd>
									<dd><span>外观漂亮</span><em>(786)</em></dd>
									<dd><span>系统流畅</span><em>(1091)</em></dd>
									<dd><span>功能齐全</span><em>(1109)</em></dd>
									<dd><span>反应快</span><em>(659)</em></dd>
									<dd><span>分辨率高</span><em>(824)</em></dd>
								</dl>
							</div>
						</div>

						<!-- 分页信息 start -->
						<div class="page mt20" id="comment_page">
							<a href="javascript:void(0);" id="scroll_btn" onclick="ajaxGetCommentByPageNum();">加载更多</a>
						</div>
						<!-- 分页信息 end -->

						<!--  评论表单 start-->
						<div class="comment_form mt20" id="comment_form">
							<!-- <a id="login_a" href="<?php echo U('Home/Member/saveAndlogin');?>">登陆之后可以评论</a> -->
							<a id="login_a" href="javascript:void(0);">登陆之后可以评论</a>
						</div>	
						<!--  评论表单 end-->
						
					</div>
					<!-- 商品评论 end -->

					<!-- 售后保障 start -->
					<div class="after_sale mt15 none detail_div">
						<div>
							<p>本产品全国联保，享受三包服务，质保期为：一年质保 <br />如因质量问题或故障，凭厂商维修中心或特约维修点的质量检测证明，享受7日内退货，15日内换货，15日以上在质保期内享受免费保修等三包服务！</p>
							<p>售后服务电话：800-898-9006 <br />品牌官方网站：http://www.lenovo.com.cn/</p>

						</div>

						<div>
							<h3>服务承诺：</h3>
							<p>本商城向您保证所售商品均为正品行货，京东自营商品自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务（奢侈品、钟表除外；奢侈品、钟表由本商城联系保修，享受法定三包售后服务），与您亲临商场选购的商品享受相同的质量保证。本商城还为您提供具有竞争力的商品价格和运费政策，请您放心购买！</p> 
							
							<p>注：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p>

						</div>
						
						<div>
							<h3>权利声明：</h3>
							<p>本商城上的所有商品信息、客户评价、商品咨询、网友讨论等内容，是京东商城重要的经营资源，未经许可，禁止非法转载使用。</p>
							<p>注：本站商品信息均来自于厂商，其真实性、准确性和合法性由信息拥有者（厂商）负责。本站不提供任何保证，并不承担任何法律责任。</p>

						</div>
					</div>
					<!-- 售后保障 end -->

				</div>
			</div>
			<!-- 商品详情 end -->

			
		</div>
		<!-- 商品信息内容 end -->
		
	</div>
	<!-- 商品页面主体 end -->
<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="">购物流程</a></li>
				<li><a href="">会员介绍</a></li>
				<li><a href="">团购/机票/充值/点卡</a></li>
				<li><a href="">常见问题</a></li>
				<li><a href="">大家电</a></li>
				<li><a href="">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="">上门自提</a></li>
				<li><a href="">快速运输</a></li>
				<li><a href="">特快专递（EMS）</a></li>
				<li><a href="">如何送礼</a></li>
				<li><a href="">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="">货到付款</a></li>
				<li><a href="">在线支付</a></li>
				<li><a href="">分期付款</a></li>
				<li><a href="">邮局汇款</a></li>
				<li><a href="">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="">退换货政策</a></li>
				<li><a href="">退换货流程</a></li>
				<li><a href="">价格保护</a></li>
				<li><a href="">退款说明</a></li>
				<li><a href="">返修/退换货</a></li>
				<li><a href="">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="">夺宝岛</a></li>
				<li><a href="">DIY装机</a></li>
				<li><a href="">延保服务</a></li>
				<li><a href="">家电下乡</a></li>
				<li><a href="">京东礼品卡</a></li>
				<li><a href="">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->


<script type="text/javascript">
	//计算会员价格-最近浏览记录
	var goodsId = <?php echo $info['id'];?>;
	$.ajax({
		type : "GET",
		url : "<?php echo U('ajaxGetData', '', FALSE); ?>/goods_id/"+goodsId,
		success : function(data){
			$("#memberPrice").html(data);
		}

	});

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
				str += '<dl><dt><a href="<?php echo U('Home/Index/Goods', '', FALSE);?>/id/"'+v.id+'><img src="'+img_url+v.sm_logo+'" alt="" /></a></dt><dd><a href="">'+v.goods_name+'</a></dd></dl>';
				if(k==2)
					return 0;
			});
			$("#goods_recent_display").html(str);
		}
	});

	$.ajax({
		type : "GET",
		url : "<?php echo U('ajaxGetComment', '', false);?>/goods_id/"+goodsId,
		dataType : "JSON",
		success : function(data)
		{
			//如果登陆了，就把表单放到页面中
			if(data.login == 1)
			{
				$("#comment_form").html('<form id="form_comment" action=""><input type="hidden" name="goods_id" value="<?php echo $info['id'];?>"><ul><li><label for=""> 评分：</label><input type="radio" name="star" value="5"/> <strong class="star star5"></strong><input type="radio" name="star" value="4"/> <strong class="star star4"></strong><input type="radio" name="star" checked="checked" value="3"/> <strong class="star star3"></strong><input type="radio" name="star" value="2"/> <strong class="star star2"></strong><input type="radio" name="star" value="1"/><strong class="star star1"></strong></li><li><label for="">评价内容：</label><textarea name="content" cols="" rows=""></textarea></li><li><label>印象：</label><input name="yx">多个印象用","隔开</li><li><label for="">&nbsp;</label><input type="submit" value="提交评论" id="btn_comment" class="comment_btn"/></li></ul></form>');
				$("#btn_comment").click(function(){
					var formData = $("#form_comment").serialize();
					alert(formData);
					$.ajax({
						type : "POST",
						url : "<?php echo U('Home/Comment/add');?>",
						data : formData,
						dataType : "JSON",
						success : function(data){
							if(data.ok == 1)
							{
								//把评论的内容放到页面中
								var html = '<div class="comment_items mt10" style="display:none"><div class="user_pic"><dl><dt><a href=""><img src="/jn/Public/Home/images/user3.jpg" alt="" /></a></dt><dd><a href="">'+data.email+'</a></dd></dl></div><div class="item"><div class="title"><span>'+data.addtime+'</span><strong class="star star'+data.star+'"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 --></div><div class="comment_content">'+data.content+'</div><div class="btns"><a href="" class="reply">回复(0)</a><a href="" class="useful">有用(0)</a></div></div><div class="cornor"></div></div>';
								$('.comment_summary').after(html);
								document.getElementById('form_comment').reset();
								//让滚动条滚到评论所在位置
								$("body").animate({scrollTop:"710px"},300,'linear',function(){html.fadeIn('slow');});
							}
							else
								alert(data.error);
						}
					});
					return false;
				});
			}
		}
	});

	$("#login_a").click(function(){
		$.ajax({
			type : "GET",
			url : "<?php echo U('Home/Member/saveAndlogin'); ?>",
			success : function(data)
			{
				location.href = "<?php echo U('Home/Member/login') ?>";
			}	
		});
	});
	//ajax获取评论的数据，每页显示5条评论，当滚动到最后一条评论是，在自动加载5条评论
	var current_comment_page = 1;//当前在再到第几页
	function ajaxGetCommentByPageNum()
	{
		$.ajax({
			type : "GET",
			url : "<?php echo U('Home/Comment/ajaxGetComment', '', false);?>/p/"+current_comment_page+"/goods_id/"+<?php echo $info['id'];?>,
			dataType : "JSON",
			success : function(data)
			{
				//循环服务器中返回的数据
				var html = "";
				$(data).each(function(k, v){
					html += '<div class="comment_items mt10"><div class="user_pic"><dl><dt><a href=""><img src="/jn/Public/Home/images/user3.jpg" alt="" /></a></dt><dd><a href="">'+v.email+'</a></dd></dl></div><div class="item"><div class="title"><span>'+v.addtime+'</span><strong class="star star'+v.star+'"></strong> <!-- star5表示5星级 start4表示4星级，以此类推 --></div><div class="comment_content">'+v.content+'</div><div class="btns"><a href="" class="reply">回复('+v.reply_count+')</a><a href="" class="useful">有用('+v.used+')</a></div></div><div class="cornor"></div></div>';
				});
				$("#comment_page").before(html);
				current_comment_page++;
				// pending=0;
				if(data == null)
					$(window).unbind("scroll");
			}
		});
	}
	ajaxGetCommentByPageNum();

	// 获取加载更多按钮的指针
	// var pending = 0; //判断当前是否正在发送请求
	var a_load_more = $("#scroll_btn");
	var p = a_load_more.offset();
	$(window).scroll(function(){
		if(penging == 1)
			return ;
		//获取位置
		// if(p.top == $(window).scrollTop())
		// {
		// 	a_load_more.trigger('click');
		// 	pending = 1;
		// }
	})
</script>

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