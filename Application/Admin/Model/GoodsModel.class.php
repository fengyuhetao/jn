<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model 
{
	// 在添加时调用create方法时允许接收的字段
	protected $insertFields = array('goods_name','price','goods_desc','is_on_sale');
	// 在修改时表单中可以有哪些字段
	protected $updateFields = array('id', 'goods_name','price','goods_desc','is_on_sale');
	// 定义表单验证的规则，控制器中的create方法时用
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1),
		array('goods_name', '1,45', '商品名称必须是1-45个字符', 1, 'length'),
		array('price', 'currency', '价格必须是货币格式', 1),
		array('is_on_sale', '0,1', '是否上架只能是0,1两个值', 1, 'in'),
	);
	// TP在调用add方法之前会自动调用这个方法，我们可以把在插入数据库之前要执行的代码写到这里
	// 第一个参数：就是表单中的数据（要插入到数据库中的数据）是一个一维数组
	// 第二个参数：额外信息，：当前模型对应的实际的表名是什么
	// 说明：在这个函数中要改变这个函数外部的$data，需要按钮引用传递，否则修改也无效
	// 说明：如果return false是指控制器中的add方法返回了false
	protected function _before_insert(&$data, $option)
	{
		// 获取当前时间
		$data['addtime'] = time();
		// 上传LOGO
		$ret = uploadOne('logo', 'Goods', array(
			array(150, 150),
			));
		if($ret['ok'] == 1){
			//上传成功,把图片放到数据库中
			$data['logo'] = $ret['images'][0];
			$data['sm_logo'] = $ret['images'][1];
		}
		else{
			$this->error = $ret['error'];
			return FALSE;
		}
	}

	//在控制器中调用delete方法之前自动调用
	protected function _before_delete(&$data, $option)
	{
		$logo = $this->field('logo,sm_logo')->find($option['where']['id']);
		//删除图片
		$rp = C('IMG_rootPath');
		unlink($rp.$logo['logo']);
		unlink($rp.$logo['sm_logo']);
		// var_dump($option);
	}

	protected function _before_update(&$data, $option)
	{
		if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0)
		{
			$rootPath = C('IMG_rootPath');
			$upload = new \Think\Upload(array(
				'rootPath' => $rootPath,
			));// 实例化上传类
		    $upload->maxSize = (int)C('IMG_maxSize') * 1024 * 1024;// 设置附件上传大小
		    $upload->exts = C('IMG_exts');// 设置附件上传类型
		   /// $upload->rootPath = $rootPath; // 设置附件上传根目录
		    $upload->savePath = 'Goods/'; // 图片二级目录的名称
		    // 上传文件 
		    $info   =   $upload->upload();
		    if(!$info)
		    {
		    	// 先把上传失败的错误信息存到模型中，由控制器最终再获取这个错误信息并显示
		        $this->error = $upload->getError();
		        return FALSE; // 返回控制器
		    }
		    else
		    {
		    	$logoName = $info['logo']['savepath'] . $info['logo']['savename'];
		    	// 拼出缩略图的文件名
		    	$smLogoName = $info['logo']['savepath'] . 'thumb_' .$info['logo']['savename'];
		    	// 生成缩略图
		    	$image = new \Think\Image();
		    	// 打开要处理的图片
		    	$image->open($rootPath.$logoName);
		    	$image->thumb(150, 150)->save($rootPath.$smLogoName);
		    	// 把图片的表单放到表单中
		    	$data['logo'] = $logoName;
		    	$data['sm_logo'] = $smLogoName;
		    	//删除原图片
		    	$logo = $this->field('logo,sm_logo')->find($option['where']['id']);
				//删除图片
				$rp = C('IMG_rootPath');
				unlink($rp.$logo['logo']);
				unlink($rp.$logo['sm_logo']);
				// var_dump($option);
		    }
		}
	}
	public function search()
	{
		/************ 搜索 ****************/
		$where = array();  // 默认情况下的搜索条件为空
		// 商品名称的搜索
		$goodsName = I('get.goods_name');
		if($goodsName)
			$where['goods_name'] = array('like', "%$goodsName%");
		// 价格的搜索
		$startPrice = I('get.start_price');
		$endPrice = I('get.end_price');
		if($startPrice && $endPrice)
			$where['price'] = array('between', array($startPrice, $endPrice));
		elseif ($startPrice)
			$where['price'] = array('egt', $startPrice);
		elseif ($endPrice)
			$where['price'] = array('elt', $endPrice);
		// 上架的搜索
		$isOnSale = I('get.is_on_sale', -1);
		if($isOnSale != -1)
			$where['is_on_sale'] = array('eq', $isOnSale); 
		// 是否删除的搜索
		$isDelete = I('get.is_delete', -1);
		if($isDelete != -1)
			$where['is_delete'] = array('eq', $isDelete); 
		// 时间的搜索
		$startAddtime = I('get.start_addtime');
		$endAddtime = I('get.end_addtime');
		if($startAddtime && $endAddtime)
			$where['addtime'] = array('between', array(strtotime("$startAddtime 00:00:00"), strtotime("$endAddtime 23:59:59")));
		elseif ($startAddtime)
			$where['addtime'] = array('egt', strtotime("$startAddtime 00:00:00"));
		elseif ($endAddtime)
			$where['addtime'] = array('elt', strtotime("$endAddtime 23:59:59"));
		/***************** 排序 ******************/
		$orderby = 'id';  // 默认排序字段
		$orderway = 'desc'; // 默认排序方式
		$odby = I('get.odby');
		if($odby && in_array($odby, array('id_asc','id_desc','price_asc','price_desc')))
		{
			if($odby == 'id_asc')
				$orderway = 'asc';
			elseif ($odby == 'price_asc')
			{
				$orderby = 'price';
				$orderway = 'asc';
			}
			elseif ($odby == 'price_desc')
				$orderby = 'price';
		}
		/************ 翻页 *************/
		// 总的记录数
		$count = $this->where($where)->count();
		// 生成翻页对象
		$page = new \Think\Page($count, 5);
		$page->setConfig('next', '下一页');
		$page->setConfig('prev', '上一页');
		// 获取翻页字符串
		$pageString = $page->show();
		// 取出当前页的数据
		$data = $this->where($where)->limit($page->firstRow.','.$page->listRows)->order("$orderby $orderway")->select();
		
		//echo $this->getLastSql();
		
		return array(
			'page' => $pageString,
			'data' => $data,
		);
	}
}










