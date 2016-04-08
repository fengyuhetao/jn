<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
	protected $insertFields = array('goods_name','cate_id','brand_id','type_id','market_price','shop_price','jifen','jyz','jifen_price','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','seo_keyword','seo_description','sort_num','goods_desc','is_on_sale','is_delete','is_promote');
	protected $updateFields = array('id','goods_name','cate_id','brand_id','type_id','market_price','shop_price','jifen','jyz','jifen_price','promote_price','promote_start_time','promote_end_time','is_hot','is_new','is_best','seo_keyword','seo_description','sort_num','goods_desc','is_on_sale','is_delete','is_promote');
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1, 'regex', 3),
		array('goods_name', '1,45', '商品名称的值最长不能超过 45 个字符！', 1, 'length', 3),
		array('cate_id', 'require', '主分类id不能为空！', 1, 'regex', 3),
		array('cate_id', 'number', '主分类id必须是一个整数！', 1, 'regex', 3),
		array('type_id', 'number', '商品类型的ID必须是一个整数！', 2, 'regex', 3),
		array('market_price', 'currency', '市场商品价格必须是货币格式！', 2, 'regex', 3),
		array('shop_price', 'currency', '本店商品价格必须是货币格式！', 2, 'regex', 3),
		// array('jifen', 'require', '赠送积分不能为空！', 1, 'regex', 3),
		array('jifen', 'number', '赠送积分必须是一个整数！', 1, 'regex', 3),
		// array('jyz', 'require', '赠送经验值不能为空！', 1, 'regex', 3),
		array('jyz', 'number', '赠送经验值必须是一个整数！', 1, 'regex', 3),
		array('jifen_price', 'number', '如果要用积分兑换,需要的积分数,0代表不能用积分兑换必须是一个整数！', 2, 'regex', 3),
		array('promote_price', 'currency', '促销价必须是货币格式！', 2, 'regex', 3),
		// array('promote_start_time', 'number', '促销开始时间必须是一个整数！', 1, 'regex', 3),
		// array('promote_end_time', 'number', '促销结束时间必须是一个整数！', 1, 'regex', 3),
		array('is_hot', 'number', '是否热卖必须是一个整数！', 2, 'regex', 3),
		array('is_new', 'number', '是否新品必须是一个整数！', 2, 'regex', 3),
		array('is_best', 'number', '是否精品必须是一个整数！', 2, 'regex', 3),
		array('seo_keyword', '1,150', 'seo_关键字的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('seo_description', '1,150', 'seo_描述的值最长不能超过 150 个字符！', 2, 'length', 3),
		array('sort_num', 'number', '排序数字必须是一个整数！', 2, 'regex', 3),
		array('is_on_sale', 'number', '是否上架：1：上架，0：下架必须是一个整数！', 2, 'regex', 3),
		array('is_delete', 'number', '是否已经删除，1：已经删除 0：未删除必须是一个整数！', 2, 'regex', 3),
	);
	public function search($isDelete = 0, $pageSize = 1)
	{
		/**************************************** 搜索 ****************************************/
		$where = array('is_delete' => $isDelete);
		if($goods_name = I('get.goods_name'))
			$where['goods_name'] = array('like', "%$goods_name%");
		if($cate_id = I('get.cate_id'))
			$where['cate_id'] = array('eq', $cate_id);
		if($brand_id = I('get.brand_id'))
			$where['brand_id'] = array('eq', $brand_id);
		if($type_id = I('get.type_id'))
			$where['type_id'] = array('eq', $type_id);
		$shop_pricefrom = I('get.shop_pricefrom');
		$shop_priceto = I('get.shop_priceto');
		if($shop_pricefrom && $shop_priceto)
			$where['shop_price'] = array('between', array($shop_pricefrom, $shop_priceto));
		elseif($shop_pricefrom)
			$where['shop_price'] = array('egt', $shop_pricefrom);
		elseif($shop_priceto)
			$where['shop_price'] = array('elt', $shop_priceto);
		$is_hot = I('get.is_hot');
		if($is_hot != '' && $is_hot != '-1')
			$where['is_hot'] = array('eq', $is_hot);
		$is_new = I('get.is_new');
		if($is_new != '' && $is_new != '-1')
			$where['is_new'] = array('eq', $is_new);
		$is_best = I('get.is_best');
		if($is_best != '' && $is_best != '-1')
			$where['is_best'] = array('eq', $is_best);
		$is_on_sale = I('get.is_on_sale');
		if($is_on_sale != '' && $is_on_sale != '-1')
			$where['is_on_sale'] = array('eq', $is_on_sale);
		$addtimefrom = I('get.addtimefrom');
		$addtimeto = I('get.addtimeto');
		if($addtimefrom && $addtimeto)
			$where['addtime'] = array('between', array(strtotime("$addtimefrom 00:00:00"), strtotime("$addtimeto 23:59:59")));
		elseif($addtimefrom)
			$where['addtime'] = array('egt', strtotime("$addtimefrom 00:00:00"));
		elseif($addtimeto)
			$where['addtime'] = array('elt', strtotime("$addtimeto 23:59:59"));
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->field('a.*,IFNULL(SUM(b.goods_number), 0) gn')->alias('a')->join('left join jn_goods_number b on a.id=b.goods_id')->where($where)->group('a.id')->order('id DESC')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}

	// 添加前
	protected function _before_insert(&$data, $option)
	{

		//获取当前事件存到数据库中
		$data['addtime'] = time();
		if(isset($data['is_promote']))
            $data['is_promote'] = 1;
        // else{
        	// $data['promote_start_time'] = strtotime(I('post.promote_start_time'));
        	// $data['promote_end_time']   = strtotime(I('post.promote_end_time'));
        // }
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$ret = uploadOne('logo', 'Admin', array(
				array(150, 150, 2),
			));
			if($ret['ok'] == 1)
			{
				$data['logo'] = $ret['images'][0];
				$data['sm_logo'] = $ret['images'][1];
			}
			else 
			{
				$this->error = $ret['error'];
				return FALSE;
			}
		}
	}

	//商品插入表单之后
	protected function _after_insert($data, $option)
	{
		/***********   插入扩展分类 *************/
		$eci = I('post.extend_cate_id');
		if($eci)
		{
			$gcModel = M('GoodsCate');
			foreach ($eci as $v) {
				# code...
				if(empty($v))
					continue;
				$gcModel->add(array(
					'goods_id' => $data['id'],
					'cate_id' => $v,
					));
			}
		}
		
		/***********   插入会员价格 *************/
		$mp = I('post.mp');
		if($mp)
		{
			$mpModel = M('MemberPrice');
			foreach ($mp as $k => $v) {
				if(empty($v))
				{
					continue;
				}
				$mpModel->add(array(
					'goods_id' => $data['id'],
					'level_id' => $k,
					'price' => $v,
					));
			}
		}

		/***********  插入商品属性  *************/
		$ga = I('post.ga');
		$ap = I('post.attr_price');
		if($ga){
			$gaModel = M('GoodsAttr');
			foreach ($ga as $k => $v) {
				if(is_array($v))
				{
					foreach ($v as $k1 => $v1) {
						if(empty($v1))
							continue;
						if(is_null($ap[$k][$k1]))
							$ap[$k][$k1] = "";
						$gaModel->add(array(
							'goods_id' => $data['id'],
							'attr_id' => $k,
							'attr_value' => $v1,
							'attr_price' => $ap[$k][$k1],
							));
					}
				}
				else
				{
					if(empty($v))
						continue;
					$gaModel->add(array(
						'goods_id' => $data['id'],
						'attr_id' => $k,
						'attr_value' => $v,
						));
				}	
			}	
		}

		/***********  插入商品图片  *************/
		$gpModel = M('GoodsPics');
		if(hasImage('pics'))
		{
			//批量上传之后的$_FILES数组
			$pics = array();
			foreach ($_FILES['pics']['name'] as $k => $v) {
				if($_FILES['pics']['size'][$k] == 0)
					continue;
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pics']['type'][$k],
					'tmp_name' => $_FILES['pics']['tmp_name'][$k], 
					'error' => $_FILES['pics']['error'][$k], 
					'size' => $_FILES['pics']['size'][$k], 
					);
			}
			//在后面电泳uploadOne方法是会调用$_FILES数组上传图片,所以我们要把处理好的数组赋值给$_FILES
			$_FILES = $pics;
			//循环所有的图片一张一张的上传
			foreach ($pics as $k => $v) {
				$ret = uploadOne($k, 'Goods', array(
					array(150, 150),
					));
				if($ret['ok'] == 1){
					$gpModel->add(array(
						'goods_id' => $data['id'],
						'pic' => $ret['images'][0],
						'sm_pic' => $ret['images'][1],
						));
				}
			}
		}

	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		//判断是否修改了商品的类型,如果修改了类型，删除原来的商品类型
		//先取出原来的类型是什么
		if(I('post.old_type_id') != $data['type_id'])
		{
			//删除当前商品所欲之前的属性
			$gaModel = M('GoodsAttr');
			$gaModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		} 
		//如果没有勾选促销价格复选框设置为0
		if(!isset($_POST['is_promote']))
		{
			$data['is_promote'] = 0;
		}
		else
		{
			$data['is_promote'] = 1;
			$data['promote_start_time'] = strtotime(I('post.promote_start_time'));
			$data['promote_end_time']   = strtotime(I('post.promote_end_time'));
		}	
	}
	//修改商品表单后
	protected function _after_update($data, $option)
	{
		/***********   修改扩展分类 *************/		
		$gcModel = M('GoodsCate');
		//删除商品原来的扩展分类数据
		$gcModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		$eci = I('post.extend_cate_id');
		if($eci)
		{
			foreach ($eci as $v) {
				if(empty($v))
					continue;
				$gcModel->add(array(
					'goods_id' => $data['id'],
					'cate_id' => $v,
					));
			}
		}
		
		/***********   修改会员价格 *************/
		$mpModel = M('MemberPrice');
		//删除商品原来的会员价格数据
		$mpModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		$mp = I('post.mp');
		if($mp)
		{
			foreach ($mp as $k => $v) {
				if(empty($v))
				{
					continue;
				}
				$mpModel->add(array(
					'goods_id' => $data['id'],
					'level_id' => $k,
					'price' => $v,
					));
			}
		}

		/***********  修改商品属性  *************/
		//添加新的属性
		$ga = I('post.ga');
		$ap = I('post.attr_price');
		$gaModel = M('GoodsAttr');
		if($ga){	
			foreach ($ga as $k => $v) {
				if(is_array($v))
				{
					foreach ($v as $k1 => $v1) {
						if(empty($v1))
							continue;
						if(is_null($ap[$k][$k1]))
							$ap[$k][$k1] = "";
						$gaModel->add(array(
							'goods_id' => $option['where']['id'],
							'attr_id' => $k,
							'attr_value' => $v1,
							'attr_price' => $ap[$k][$k1],
							));
					}
				}
				else
				{
					if(empty($v))
						continue;
					$gaModel->add(array(
						'goods_id' => $option['where']['id'],
						'attr_id' => $k,
						'attr_value' => $v,
						));
				}	
			}	
		}
		//修改原来的属性
		$oldga = I('post.old_ga');
		$oldap = I('post.old_attr_price');
		if($oldga){
			foreach ($oldga as $k => $v) {
				if(is_array($v))
				{
					foreach ($v as $k1 => $v1) {
						$oldField = array(
							'attr_value' => $v1,
							);
						if(is_null($ap[$k][$k1]))
							$oldap[$k][$k1] = "";
						//如果有对应的价格,也修改
						if(isset($oldap[$k]))
							$oldField['attr_price'] = $oldap[$k][$k1];
						$gaModel->where(array('id' => array('eq', $k1)))->save($oldField);
					}
				}
				else
				{
					if(empty($v))
						$v = "";
					$gaModel->where(array('attr_id' => array('eq', $k)))->save(array(
						'attr_value' => $v,
						));
				}	
			}	
		}

		/***********  修改商品图片  *************/
		$gpModel = M('GoodsPics');
		if(hasImage('pics'))
		{
			//批量上传之后的$_FILES数组
			$pics = array();
			foreach ($_FILES['pics']['name'] as $k => $v) {
				if($_FILES['pics']['size'][$k] == 0)
					continue;
				$pics[] = array(
					'name' => $v,
					'type' => $_FILES['pics']['type'][$k],
					'tmp_name' => $_FILES['pics']['tmp_name'][$k], 
					'error' => $_FILES['pics']['error'][$k], 
					'size' => $_FILES['pics']['size'][$k], 
					);
			}
			//在后面电泳uploadOne方法是会调用$_FILES数组上传图片,所以我们要把处理好的数组赋值给$_FILES
			$_FILES = $pics;
			//循环所有的图片一张一张的上传
			foreach ($pics as $k => $v) {
				$ret = uploadOne($k, 'Goods', array(
					array(150, 150),
					));
				if($ret['ok'] == 1){
					$gpModel->add(array(
						'goods_id' => $option['where']['id'],
						'pic' => $ret['images'][0],
						'sm_pic' => $ret['images'][1],
						));
				}
			}
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		if(is_array($option['where']['id']))
		{
			$this->error = '不支持批量删除';
			return FALSE;
		}
		$images = $this->field('logo,sm_logo')->find($option['where']['id']);
		deleteImage($images);
		/************************************ 删除商品的其他属性 ********************************************/
		//扩展分类
		$gcModel = M('GoodsCate');
		$gcModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		//商品属性
		$gaModel = M('GoodsAttr');
		$gaModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		// 会员价格
		$mpModel = M('MemberPrice');
		$mpModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		// 商品库存量
		$gnModel = M('GoodsNumber');
		$gnModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
		// 商品图片
		$mpicModel = M('GoodsPics');
		$pics = $mpicModel->field('pic, sm_pic')->where(array('goods_id' => array('eq', $option['where']['id'])))->select();
		foreach ($pics as $k => $v) {
			deleteImage($v);
		}
		$mpicModel->where(array('goods_id' => array('eq', $option['where']['id'])))->delete();
	}

	/**
	 * 取出促销的商品
	 * @param  integer $limit [description]
	 * @return [array]         [description]
	 */
	public function getPromoteGoods($limit = 5)
	{
		$now = time();
		return $this->field('id, goods_name, promote_price, sm_logo')->where(array(
			'is_on_sale' => array('eq', 1),		 //上架
			'is_delete'  => array('eq', 0),      //没被删除
			'is_promote' => array('eq', 1),		 //促销商品
			'promote_start_time' => array('elt', $now), 
			'promote_end_time' => array('egt', $now), //在促销时间内
			))->order('sort_num ASC')->limit($limit)->select();
	}

	/**
	 * 取得最新的商品
	 * @param  integer $limit [description]
	 * @return [type]         [description]
	 */
	public function getNewGoods($limit = 5)
	{
		return $this->field('id, goods_name, shop_price, sm_logo')->where(array(
			'is_on_sale' => array('eq', 1),		 //上架
			'is_delete'  => array('eq', 0),      //没被删除
			'is_new' => array('eq', 1),		 //促销商品
			))->order('sort_num ASC')->limit($limit)->select();
	}

	/**
	 * 取得最热的商品
	 * @param  integer $limit [description]
	 * @return [type]         [description]
	 */
	public function getHotGoods($limit = 5)
	{
		return $this->field('id, goods_name, shop_price, sm_logo')->where(array(
			'is_on_sale' => array('eq', 1),		 //上架
			'is_delete'  => array('eq', 0),      //没被删除
			'is_hot' => array('eq', 1),		 //促销商品
			))->order('sort_num ASC')->limit($limit)->select();
	}

	/**
	 * 取得推荐的商品
	 * @param  integer $limit [description]
	 * @return [type]         [description]
	 */
	public function getBestGoods($limit = 5)
	{
		return $this->field('id, goods_name, shop_price, sm_logo')->where(array(
			'is_on_sale' => array('eq', 1),		 //上架
			'is_delete'  => array('eq', 0),      //没被删除
			'is_best' => array('eq', 1),		 //促销商品
			))->order('sort_num ASC')->limit($limit)->select();
	}

	/**
	 * 计算会员价格
	 * @param  [type] $goodsId [description]
	 * @return [type]          [description]
	 */
	public function ajaxMemberPrice($goodsId){
		//判断用户是否登录
		$memberId = session('home_id');
		$level_id = session('level_id');
		$now = time();
		//先判断是否是促销的
		$price = $this->field('shop_price, is_promote, promote_price, promote_start_time, promote_end_time')->find($goodsId);
		if($price['is_promote'] == 1 && ($price['promote_start_time'] < $now && $price['promote_end_time'] > $now))
		{
			return $price['promote_price'];
		}	

		if(is_null($memberId))
			return $price['shop_price'];

		//该商品当前不在促销
		//1.先取出当前会员的级别
		$mpModel = M('MemberPrice');
		$mpPrice = $mpModel->field('price')->where(array('goods_id' => array('eq', $goodsId), 'level_id' => array('eq', $level_id)))->find();
		//如果有会员价格,就按会员价格算
		if($mpPrice['price'] > 0)
			return $mpPrice['price'];
		else
			//如果没有设置会员价格，就按rate算
			return session('rate')*$price['shop_price']/100;
	}

	public function convertGoodsAttrIdGoodsAttrStr($gaid)
	{
		if(gaid)
		{
			$sql = 'select GROUP_CONCAT(CONCAT(b.attr_name, ":" ,a.attr_value) SEPARATOR "<br/>") gastr from jn_goods_attr a left join jn_attribute b on a.attr_id = b.id where a.id in('.$gaid.')';
			$ret = $this->query($sql);
			return $ret[0]['gastr'];
		}
		else
			return '';
	}

	/**
	 * 前台商品搜索功能
	 * @return [type] [description]
	 */
	public function search_goods()
	{
		/********************* 搜索 **********************/
		$where = array(
			'a.is_on_sale' => array('eq', 1),
			'a.is_delete' => array('eq', 0),
			);
		//如果传了分类ID
		$catid = I('get.cid');
		if($catid)
		{
			//主分类和扩展分类下的商品都可以搜索出来
			//作为扩展分类下有没有商品
			$gcModel = M('GoodsCate');
			$goodsId = $gcModel->field('GROUP_CONCAT(DISTINCT goods_id) goods_id')->where(array('cate_id' => array('eq', $catid)))->select();
			//商品子分类也应该搜索到
			if(empty($goodsId))
			{
				$extGoodsId =" or a.id in({$goodsId['goods_id']})";
			}	
			else
			{
				$extGoodsId = '';
			}
			$where['a.cate_id'] = array('exp', "=$catid $extGoodsId");
		}	
		/************************ 价格搜索 *****************/
		$price = I('get.price');
		if($price)
		{
			$price = explode('-', $price);
			$where['a.shop_price'] = array('between', array($price[0], $price[1]));
		}

		$sa = I('get.search_attr');
		if($sa)
		{
			$gaModel = M('GoodsAttr');
			$sa = explode('.', $sa);
			$_att1 = null;
			foreach ($sa as $k => $v) {
				if($v != 0)
				{
					$_v = explode('-', $v);
					$attrGoodsId = $gaModel->field('GROUP_CONCAT(goods_id) goods_id')->where(array(
						'attr_id' => $_v[1],
						'attr_value' => $_v[0],
						))->find();
					if($_att1 === null)
					{
						$_att1 = explode(',', $attrGoodsId['goods_id']);
					}
					else
					{
						$_attrGoodsId = explode(',', $attrGoodsId['goods_id']);
						$_att1 = array_intersect($_att1, $_attrGoodsId);
						if(empty($_att1))
							break;
					}
				}
			}
			if($_att1)
				$where['a.id'] = array('in', $_att1);
			else
				$where['a.id'] = array('eq', 0); //这里让上商品搜不出来
		}

		/********************* 销量 ************************/
		$orderBy = 'xl';                  //默认排序字段  
		$orderWay = 'desc';                   //默认排序方式
		//接收用户的排序方式
		$ob = I('get.ob');  //获取排序属性
		$ow = I('get.ow');	//获取排序方式
		if ($ob && in_array($ob, array('xl', 'price', 'pl', 'addtime', 'shop_price'))) {
			$orderBy = $ob;
			if($ob == 'shop_price' && $ow && in_array(strtolower($ow), array('asc', 'desc')))
			{
				$orderWay = $ow;
			}
		}
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, 24);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();

		/************************************** 取商品数据 ******************************************/
		$data['data'] = $this->alias('a')->field('a.id,a.shop_price,a.sm_logo,a.goods_name,IFNULL(SUM(b.goods_number),0) xl,(select count(id) from jn_comment c where c.goods_id = a.id) pl')->join('left join jn_order_goods b on (a.id=b.goods_id and b.order_id in (select id from jn_order where pay_status=1))')->where($where)->group('a.id')->order("$orderBy $orderWay")->limit($page->firstRow.','.$page->listRows)->select();

		//  select a.id,a.goods_name,IFNULL(SUM(b.goods_number),0) xl,(select count(id) from jn_comment c where c.goods_id = a.id) pl from jn_goods a left join jn_order_goods b on (a.id=b.goods_id and b.order_id in (select id from jn_order where pay_status=1)) group by a.id order by xl asc;
		//  总结:使用两个都外链，那么取出的结果会互相影响，所以销量使用的left join,评论用的子查询

		return $data;
	}
}