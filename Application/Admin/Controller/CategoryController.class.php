<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class CategoryController extends IndexController 
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin/Category');
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
		$parentModel = D('Admin/Category');
		$parentData = $parentModel->getTree();
		$this->assign('parentData', $parentData);

        //取出所有的商品分类
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData', $typeData);

		$this->setPageBtn('添加商品分类表', '商品分类表列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Admin/Category');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
                    echo $model->getLastSql();
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
        //取出所有的商品分类
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData', $typeData);

        //取出该分类的所有信息
    	$model = M('Category');
    	$data = $model->find($id);
    	$this->assign('data', $data);

        if($data['search_attr_id'])
        {
            $attrModel = M('Attribute');
            $search_attr_id = explode(',', $data['search_attr_id']);
            $searchAttrData = $attrModel->field('id, type_id, attr_name')->where(array('id' => array('in', $search_attr_id)))->select();
        }
        $this->assign('searchAttrData', $searchAttrData);

        //取出该商品的树状结构
		$parentModel = D('Admin/Category');
		$parentData = $parentModel->getTree();
		$children = $parentModel->getChildren($id);
        $this->assign(array(
			'parentData' => $parentData,
			'children' => $children,
		));

		$this->setPageBtn('修改商品分类表', '商品分类表列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin/Category');
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
    	$model = D('Admin/Category');
		$data = $model->getTree();
    	$this->assign(array(
    		'data' => $data,
    	));

		$this->setPageBtn('商品分类表列表', '添加商品分类表', U('add'));
    	$this->display();
    }

    public function setPageBtn($_page_title = '', $_page_btn_name = '', $_page_btn_link = '#'){
        $this->assign('_page_title', $_page_title);
        $this->assign('_page_btn_name', $_page_btn_name);
        $this->assign('_page_btn_link', $_page_btn_link);
    }
}