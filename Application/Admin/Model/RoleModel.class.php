<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model 
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		// array('role_name', '', '角色名称已经存在！', 1, 'unique', 3),	
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->field('a.*,GROUP_CONCAT(c.pri_name) pri_name')->alias('a')->join('left join jn_role_privilege b on a.id=b.role_id left join jn_privilege c on b.pri_id=c.id')->where($where)->group('a.id')->limit($page->firstRow.','.$page->listRows)->select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}

	protected function _after_insert($data, $option)
	{
		$priID = I('post.pri_id');
		if($priID)
		{
			$rpModel = M('role_privilege');
			foreach ($priID as $k => $v) {
				# code...
				$rpModel->add(array('pri_id' => $v, 'role_id' => $data['id']));
			}
		}
	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		$rpModel = M('role_privilege');
		$rpModel->where(array('role_id' => array('eq', $option['where']['id'])))->delete();
		//接收表单重新添加一遍
		$priID = I('post.pri_id');
		if($priID)
		{
			foreach ($priID as $k => $v) {
				# code...
				$rpModel->add(array('pri_id' => $v, 'role_id' => $option['where']['id']));
			}
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		//先判断有没有管理员属于该角色
		$arModel = M('admin_role');
		$has = $arModel->where(array('role_id' => array('eq', $option['where']['id'])))->count();
		if($has > 0){
			$this->error = '有管理员属于当前角色,无法删除';
			return false;
		}

		$rpModel = M('role_privilege');
		$rpModel->where(array('role_id' => array('eq', $option['where']['id'])))->delete();
	}
	// 删除后
	protected function _after_delete($option)
	{

	}
	/************************************ 其他方法 ********************************************/
}