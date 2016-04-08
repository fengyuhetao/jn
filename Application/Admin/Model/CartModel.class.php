<?php 
namespace Admin\Model;
use Think\Model;
class CartModel extends Model
{
	//加入购物车
	public function addToCart($goods_id, $goods_attr_id, $goods_number = 1)
	{
		$mid = session('home_id');
		if($mid)
		{	
			self::addToDatabase($mid, $goods_id, $goods_attr_id, $goods_number);
		}
		else
		{
			self::addToCookie($goods_id, $goods_attr_id, $goods_number);
		}
	}

	/**
	 * 用户未登录，将购物车中数据存到cookie中
	 * @param [type]  $goods_id      [description]
	 * @param [type]  $goods_attr_id [description]
	 * @param integer $goods_number  [description]
	 */
	public function addToCookie($goods_id, $goods_attr_id, $goods_number = 1)
	{
		//加入cookie中
		$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
		//把商品加入到该数组中
		//格式 商品id-属性id1,属性id2,...
		$key = $goods_id .'-'. $goods_attr_id;
		//设置过期时间
		$aMonth = 30*3600*24;
		// if(isset($cart[$key]))
		if(isset($cart[$key]))
		{
			//如果购物车中已存在该商品
			$cart[$key] = $cart[$key] + $goods_number;
		}
		else
		{
			//购物车中不存在该商品
			$cart[$key] = $goods_number;	
		}
		//把数组存到cookie中
		setcookie('cart', serialize($cart), time()+$aMonth, '/', 'localhost');
	}

	/**
	 * 用户登陆后，购物车中数据保存到cookie中
	 * @param [type]  $mid           [description]
	 * @param [type]  $goods_id      [description]
	 * @param [type]  $goods_attr_id [description]
	 * @param integer $goods_number  [description]
	 */
	public function addToDatabase($mid, $goods_id, $goods_attr_id, $goods_number = 1)
	{
		//加入到数据库中
		$cartModel = M('Cart');
		$has = $cartModel->where(array(
			'member_id' => array('eq', $mid),
			'goods_id' => array('eq', $goods_id),
			'goods_attr_id' => array('eq', $goods_attr_id),
			))->find();
		if($has)
			$cartModel->where('id='.$has['id'])->setInc('goods_number', $goods_number);
		else
		{
			$cartModel->add(array(
				'goods_id' => $goods_id,
				'goods_attr_id' => $goods_attr_id,
				'goods_number' => $goods_number,
				'member_id' => $mid,
				));
		}
	}

	public function cartList()
	{
		$mid = session('home_id');
		if($mid)
		{
			$cartModel = M('Cart');
			$_cart = $cartModel->where(array('member_id'=> array('eq', $mid)))->select();
		}
		else 
		{
			$_cart_ = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			//转化这个数组的数组结构和从数据库中的一样，都是二维的
			$_cart = array();
			foreach ($_cart_ as $k => $v) {
				//从下表中解析出商品id和商品属性id
				$_k = explode('-', $k);
				$_cart[] = array(
					'goods_id' => $_k[0],
					'goods_attr_id' => $_k[1],
					'goods_number' => $v,
					'member_id' => 0,
					);
			}
		}	
		/****************循环数据，根据ID得到商品详情页*********************/
		$goodsModel = D('Admin/Goods');
		foreach ($_cart as $k => $v) {
			$goodsInfo = $goodsModel->field('sm_logo,goods_name')->find($v['goods_id']);
			$_cart[$k]['goods_name'] = $goodsInfo['goods_name'];
			$_cart[$k]['sm_logo'] = C('IMG_rootPath').$goodsInfo['sm_logo'];
			$_cart[$k]['member_price'] = $goodsModel->ajaxMemberPrice($v['goods_id']);
			$_cart[$k]['goods_attr_str'] = $goodsModel->convertGoodsAttrIdGoodsAttrStr($v['goods_attr_id']);
			$_cart[$k]['total'] = intval($_cart[$k]['member_price'])*intval($_cart[$k]['goods_number']);
		}
		return $_cart;
	}

	/**
	 * 当用户登录后把cookie中的数据转移到数据库中
	 * @return [type] [description]
	 */
	public function moveCookieToDb()
	{
		$mid = session('mid');
		if($mid)
		{
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			if($cart)
			{
				foreach ($cart as $k => $v) {
					//从下标中解析出商品ID，和商品属性ID
					$_k = explode('-', $k);
					$this->addToDatabase($mid, $_k[0], $_k[1], $v);
				}
				//清空cookie中的数据
				setcookie('cart', '', time()-1, '/', 'localhost');
			}
		}
	}

	public function updateData($goods_id, $gaid, $goods_number)
	{
		$mid = session('home_id');
		if($mid)
		{
			$cartModel = M('Cart');
			if($goods_number == 0)
				$cartModel->where(array(
					'goods_id' => array('eq', $goods_id),
					'goods_attr_id' => array('eq', $gaid),
					'member_id' => array('eq', $mid),
					))->delete();
			else
				$cartModel->where(array(
					'goods_id' => array('eq', $goods_id),
					'goods_attr_id' => array('eq', $gaid),
					'member_id' => array('eq', $mid),
					))->setField('goods_number', $goods_number);
		}
		else
		{
			$cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : array();
			$key = $goods_id .'-'. $gaid;
			if($goods_number == 0)
				unset($cart[$key]);
			else
			{
				$cart[$key] = $goods_number;
			}
			$aMonth = 30*3600*24;
			setcookie('cart', serialize($cart), time()+$aMonth, '/', 'localhost');
		}
	}

	public function clear()
	{
		$mid = session('home_id');
		if($mid)
		{
			$buythis = session('buythis');

			$cartModel = M('Cart');
			//循环勾选的商品
			foreach ($buythis as $k => $v) {
				//从字符串中取出商品ID
				$_v = explode('-', $v);
				$cartModel->where(array('member_id' => array('eq', $mid), 'goods_id' => array('eq', $_v[0])))->delete();
			}	
		}
		else
			setcookie('cart', '', time()-1, '/', 'localhost');
	}
}
?>