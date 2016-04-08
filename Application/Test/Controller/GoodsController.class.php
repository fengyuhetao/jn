<?php
namespace Test\Controller;
use \Admin\Controller\IndexController;
class GoodsController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Test/Goods');
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

		$this->setPageBtn('添加商品表', '商品表列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Test/Goods');
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
    	$model = M('Goods');
    	$data = $model->find($id);
    	$this->assign('data', $data);

		$this->setPageBtn('修改商品表', '商品表列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Test/Goods');
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
    	$model = D('Test/Goods');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('商品表列表', '添加商品表', U('add'));
    	$this->display();
    }

    private function setPageBtn($_page_title = '', $_page_btn_name = '', $_page_btn_link = '#'){
        $this->assign('_page_title', $_page_title);
        $this->assign('_page_btn_name', $_page_btn_name);
        $this->assign('_page_btn_link', $_page_btn_link);
    }
}