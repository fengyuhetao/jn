<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model 
{
	protected $insertFields = array('shr_name','shr_province','shr_city','shr_area','shr_address','shr_tel','post_method','pay_method');
	//$_validate在create函数中执行
	protected $_validate = array(
		array('shr_name', 'require', '收货人姓名不能为空！', 1),
		array('shr_province', 'require', '收货人所在省不能为空！', 1),
		array('shr_city', 'require', '收货人城市不能为空！', 1),
		array('shr_area', 'require', '收货人地区不能为空！', 1),
		array('shr_address', 'require', '收货人地址不能为空！', 1),
		array('shr_tel', 'require', '收货人电话不能为空！', 1),
		array('post_method', 'require', '发货方式不能为空！', 1),
		array('pay_method', 'require', '支付方式不能为空！', 1),
	);
	
	protected function _before_insert(&$data, $options)
	{
		//判断购物车中是否有商品
		$cartModel = D('Admin/Cart');
		$cart_data = $cartModel->cartList();
		if(count($cart_data) == 0)
		{
			$this->error = '必须先购买商品';
			return false;
		}	
		//循环购物车中每件商品检查库存量,计算总价
		//加锁
		$this->fp = fopen('./a.lock', 'r');
		flock($this->fp, LOCK_EX);
		$gnModel = M('GoodsNumber');
		$total = 0;
		$buythis = session('buythis');
		foreach ($cart_data as $k => $v) {
			//判断该商品是否选过
			if(!in_array($v['goods_id'].'-'.$v['goods_attr_id'], $buythis))
				continue;
			//取出商品的库存量
			$gn = $gnModel->field('goods_number')->where(array(
				'goods_id' => array('eq', $v['goods_id']),
				'goods_attr_id' => array('eq', $v['goods_attr_id']),
				))->find();
			if($gn['goods_number'] < $v['goods_number'])
			{
				$this->error = '库存量不足';
				return false;
			}
			$total += $v['member_price']*$v['goods_number'];
		}
		//下单
		$data['member_id'] = session('home_id');
		$data['addtime'] = time();
		$data['total_price'] = $total;
		//启动事务
		mysql_query('START TRANSACTION');
	}

	protected function _after_insert($data, $options)
	{
		//循环购物车中每一个商品，减少库存量
		//把购物车中的数据存到订单商品表中
		$cartModel = D('Admin/Cart');
		$cart_data = $cartModel->cartList();
		//循环购物车中每件商品
		$ogModel = M('OrderGoods');
		$gnModel = M('GoodsNumber');
		$buythis = session('buythis');
		foreach ($cart_data as $k => $v) {
			//判断该商品是否选过
			if(!in_array($v['goods_id'].'-'.$v['goods_attr_id'], $buythis))
				continue;
			//插入到订单商品表
			$rs1 = $ogModel->add(array(
				'order_id' => $v['id'],
				'member_id' => session('home_id'),
				'goods_id' => $v['goods_id'],
				'goods_attr_id' => $v['goods_attr_id'],
				'goods_attr_str' => $v['goods_attr_str'], 
				'goods_price' => $v['member_price'], 
				'goods_number' => $v['goods_number']
 				));
			if($rs1 === FALSE)
			{
				mysql_query('ROLLBACK');
				return false;
			}	
			//减少库存
			$rs = $gnModel->where(array(
				'goods_id' => array('eq', $v['goods_id']),
				'goods_attr_id' => array('eq', $v['goods_attr_id']),
				))->setDec('goods_number', $v['goods_number']);
			if($rs == FALSE)
			{
				mysql_query('ROLLBACK');
				return false;
			}
		}
		mysql_query('COMMIT'); //提交事务
		flock($this->fp, LOCK_UN);
		fclose($this->fp);
		//清空购物车中选择的商品
		$cartModel->clear();
		session('buythis', null);
	}

	//设置订单为已支付的状态
	public function setPaid($id)
	{
		//更新订单状态为已支付状态
		$this->where(array('id' => array('eq', $id)))->setField('pay_status', 1);
		//增加会员的经验和积分
		$info = $this->field('total_price, member_id')->find($id);
		$this->execute('update jn_member set jyz=jyz+'.$info['total_price'].',jifen=jifen+'.$info['total_price'].' where id='.$info['member_id']);
	}
}