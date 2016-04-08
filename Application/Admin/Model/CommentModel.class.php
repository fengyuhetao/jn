<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model 
{
	protected $insertFields = array('content','star','goods_id');
	protected $_validate = array(
		array('content', 'require', '评论内容不能为空！', 1, 'regex', 3),
		array('star', '/^[1-5]$/', '分值必须是1到5', 1),
	);

	protected function _before_insert(&$data, $option)
	{
		$data['addtime'] = time();
		$data['member_id'] = intval(session('home_id'));
		// 处理添加的印象
		$yx = I('post.yx');
		if($yx)
		{
			//先统计字符串中的，号都用英文的
			$yx = str_replace('，', ',', $yx);
			//根据,转化为数组
			$yx = explode(',', $yx);
			$impModel = M('Impression');
			foreach ($yx as $k => $v) {
				$has = $impModel->field('id')->where(array(
					'goods_id' => array('eq', I('post.goods_id')), 
					'imp_name' => array('eq', $v),
					))->find();
				//如果数据库中存在该印象
				if($has)
					$impModel->where('id='.$has['id'])->setInc('imp_count');
				else
					$impModel->add(array(
						'goods_id' => I('post.goods_id'),
						'imp_name' => $v,
						));
			}
		}
	}
	
}