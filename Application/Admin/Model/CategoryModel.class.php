<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model 
{
	protected $insertFields = array('cate_name','parent_id');
	protected $updateFields = array('id','cate_name','parent_id','search_attr_id');
	protected $_validate = array(
		array('cate_name', 'require', '分类名称不能为空！', 1, 'regex', 3),
		array('cate_name', '1,30', '分类名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('parent_id', 'number', '父级ID,0:代表顶级必须是一个整数！', 2, 'regex', 3),
	);
	/************************************* 递归相关方法 *************************************/
	public function getTree()
	{
		$data = $this->select();
		return $this->_reSort($data);
	}
	private function _reSort($data, $parent_id=0, $level=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$v['level'] = $level;
				$ret[] = $v;
				$this->_reSort($data, $v['id'], $level+1, FALSE);
			}
		}
		return $ret;
	}
	public function getChildren($id)
	{
		$data = $this->select();
		return $this->_children($data, $id);
	}
	private function _children($data, $parent_id=0, $isClear=TRUE)
	{
		static $ret = array();
		if($isClear)
			$ret = array();
		foreach ($data as $k => $v)
		{
			if($v['parent_id'] == $parent_id)
			{
				$ret[] = $v['id'];
				$this->_children($data, $v['id'], FALSE);
			}
		}
		return $ret;
	}
	/************************************ 其他方法 ********************************************/
	public function _before_insert(&$data, $options)
	{
		$attr_id = I('post.attr_id');
		//循环把没有的属性删除
		foreach ($attr_id as $k => $v) {
			if(empty($v))
				unset($attr_id[$k]);
		}
		if($attr_id)
			$data['search_attr_id'] = implode(',', $attr_id);
 	}

	public function _before_delete($option)
	{
		// 先找出所有的子分类
		$children = $this->getChildren($option['where']['id']);
		// 如果有子分类都删除掉
		if($children)
		{
			$children = implode(',', $children);
			$this->execute("DELETE FROM jn_category WHERE id IN($children)");
		}
	}

	public function _before_update(&$data, $options)
	{
		$attr_id = I('post.attr_id');
		//循环把没有的属性删除
		foreach ($attr_id as $k => $v) {
			if(empty($v))
				unset($attr_id[$k]);
		}
		array_unique($attr_id);
		if($attr_id)
			$data['search_attr_id'] = (string)implode(',', $attr_id);
	}

	/**
	 * 获取首页导航栏上的数据
	 * @return [array] [导航栏中的数据]
	 */
	public function getNavCatData(){
		//先从缓存中读取数据
		// $data = S('catData');
		// if($data)
		// 	return $data;
		// else
		// {
			//取出所有分类方法一 
			//先取出所有的分类
			$allCat = $this->select();
			// 再从所有的分类中取出顶级分类
			foreach ($allCat as $k => $v) {
				if($v['parent_id'] == 0)
				{
					//循环找顶级分类的二级分类
					foreach ($allCat as $k1 => $v1) {
						if($v1['parent_id'] == $v['id'])
						{
							foreach ($allCat as $k2 => $v2) {
								if($v2['parent_id'] == $v1['id'])
								{
									$v1['children'][] = $v2;
								}
							}
							$v['children'][] = $v1;
						}
					}
					$data[] = $v;
				}
			}
			//取出所有分类方法二
			//先取出所有的顶级分类
			$cat = $this->field('id, cate_name')->where('parent_id = 0')->select();
			// 取出所有的二级分类
			foreach ($cat as $k => $v) {
				$cat[$k]['children'] = $this->where('parent_id = '.$v['id'])->select();
				//取出所有的三级分类
				foreach ($cat[$k]['children'] as $k1 => $v1) {
					$cat[$k]['children'][$k1]['children'] = $this->where('parent_id = '.$v1['id'])->select();
				}
			}
			
			// S('catData', $data); //将$cat缓存到catData中
			return $data;
		// }
	}
}