<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class AdminController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

        $rModel = M('Role');
        $rData = $rModel->select();
        $this->assign('rData', $rData);

		$this->setPageBtn('添加管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');

        //超级管理员可以修改所有人的信息，普通管理员只能修改自己的信息
        $adminId = session('id');
        // echo "<script>alert(".$id.");</script>";
        // echo "<script>alert(".$adminId.");</script>";
        if($adminId != 1 && $adminId != $id)
        {
            $this->error("无权修改该管理员的信息");
        }

    	if(IS_POST)
    	{
    		$model = D('Admin/Admin');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        $rModel = M('Role');
        $rData = $rModel->select();
        $this->assign('rData', $rData);

        //取出当前用户拥有的所有权限
        $arModel = M('AdminRole');
        $arData = $arModel->field('GROUP_CONCAT(role_id) role_id')->where(array('admin_id' => array('eq', $id)))->find();
        $this->assign('arData', $arData['role_id']);

		$this->setPageBtn('修改管理员', '管理员列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Admin');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Admin/Admin');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('管理员列表', '添加管理员', U('add'));
    	$this->display();
    }

    public function ajaxUpdateIsuse()
    {
        $adminId = I('get.id');
        $curId = session('id');
        // echo "<script>alert(".$adminId.");</script>";
        // echo "<script>alert(".$adminId.");</script>";
        if($curId != 1 && $curId != $adminId)
        {
            echo 2;
            return false;
        }

        $model = M('Admin');
        $info = $model -> find($adminId);
        if($info['is_use'] == 1)
        {
            $model -> where(array('id' => array('eq', $adminId)))->setField('is_use', 0);
            echo 0;
        }else{
            $model -> where(array('id' => array('eq', $adminId)))->setField('is_use', 1);
            echo 1;
        }
    }

    public function setPageBtn($_page_title = '', $_page_btn_name = '', $_page_btn_link = '#'){
        $this->assign('_page_title', $_page_title);
        $this->assign('_page_btn_name', $_page_btn_name);
        $this->assign('_page_btn_link', $_page_btn_link);
    }
}