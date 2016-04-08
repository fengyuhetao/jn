<?php
namespace Admin\Controller;
use \Admin\Controller\IndexController;
class GoodsController extends IndexController 
{
    /**
     * 添加商品
     */
    public function add()
    {
    	if(IS_POST)
    	{
            //设置php脚本可以执行的时间,单位:秒,设置为0表示永久执行到结束
            set_time_limit(0);  
            // header("content-type:text/html;charset=utf-8");
            // var_dump($_FILES);
            // var_dump($_POST); 
            // die;
            // if(!empty(I('post.promote_start_time')))
            // {
            //     I('post.promote_start_time') = time(I('post.promote_start_time'));
            // }
            // if(!empty(I('post.promote_end_time')))
            // {
            //     I('post.promote_end_time') = time(I('post.promote_end_time'));
            // }
            //处理时间的代码不能放在_before_update中，该段代码必须在过滤之前执行
            //或者自己接收，可能存在风险,代码见__before_insert()
            $addData = I('post.');
            if(isset($addData['promote_start_time']) && !empty($addData['promote_start_time']))
            {
                $addData['promote_start_time'] = strtotime($addData['promote_start_time']);
            }
            if(isset($addData['promote_end_time']) && !empty($addData['promote_end_time']))
            {
                $addData['promote_end_time'] = strtotime($addData['promote_end_time']);
            }
    		$model = D('Admin/Goods');
    		if($model->create($addData, 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}

        //从数据库中取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData', $typeData);
        
        //取出所有的商品分类
        $catModel = D('Category');
        $catData = $catModel->getTree();
        $this->assign('catData', $catData);

        //取出所有的品牌
        $brandModel = M('Brand');
        $brandData = $brandModel->select();
        $this->assign('brandData', $brandData);

        //取出所有的会员级别
        $memberLevelModel = M('MemberLevel');
        $memberLevelData = $memberLevelModel->select();
        $this->assign('memberLevelData', $memberLevelData);

		$this->setPageBtn('添加商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    /**
     * 编辑商品
     */
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
            //处理时间的代码不能放在_before_update中，该段代码必须在过滤之前执行
            //或者自己接收，可能存在风险,代码见__before_update()
            $addData = I('post.');
            // if(isset($addData['promote_start_time']) && !empty($addData['promote_start_time']))
            // {
            //     $addData['promote_start_time'] = strtotime($addData['promote_start_time']);
            // }
            // if(isset($addData['promote_end_time']) && !empty($addData['promote_end_time']))
            // {
            //     $addData['promote_end_time'] = strtotime($addData['promote_end_time']);
            // }
            header("content-type:text/html;charset=utf-8");
            $model = D('Admin/Goods');
    		if($model->create($addData, 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$gModel = M('Goods');
    	$data = $gModel->find($id);
    	$this->assign('data', $data);

        //从数据库中取出所有的扩展分类
        $gcModel = M('GoodsCate');
        $gcData = $gcModel->where(array('goods_id' => array('eq', $id)))->select();
        $this->assign('gcData', $gcData);

        //从数据库中取出所有的类型
        $typeModel = M('Type');
        $typeData = $typeModel->select();
        $this->assign('typeData', $typeData);

        //加载商品的分类
        $cModel = D('Category');
        $catData = $cModel->getTree();
        $this->assign('catData', $catData);

        //加载商品的品牌信息
        $brandModel = M('Brand');
        $brandData = $brandModel->select();
        $this->assign('brandData', $brandData);

        //取出所有的会员级别
        $memberLevelModel = M('MemberLevel');
        $memberLevelData = $memberLevelModel->select();
        $this->assign('memberLevelData', $memberLevelData);

        //取出商品会员价格
        $memberPriceModel = M('MemberPrice');
        $_memberPriceData = $memberPriceModel->field(array('level_id', 'price'))->where(array('goods_id' => array('eq', $id)))->select();
        $memberPriceData = array();
        //二维数组转一维数组
        foreach ($_memberPriceData as $k => $v) {
            $memberPriceData[$v['level_id']] = $v['price'];
        }
        $this->assign('memberPriceData', $memberPriceData);

        //取出商品所有的图片
        $gpModel = M('GoodsPics');
        $gpData = $gpModel->where(array('goods_id' => array('eq', $id)))->select();
        $this->assign('gpData', $gpData);

        //取出商品所有的属性
        $gaModel = M('GoodsAttr');
        //select a.*,b.attr_name from jn_goods_attr a left join jn_attribute b on a.attr_id = b.id
        $gaData = $gaModel->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')->alias('a')->join('left join jn_attribute b on a.attr_id = b.id')->where(array('a.goods_id' => array('eq', $id)))->order('a.attr_id')->select();
        //取出该商品没有的属性
        $attr_id = array();
        foreach ($gaData as $k => $v) {
            $attr_id[] = $v['attr_id'];
        }
        $attr_id = array_unique($attr_id);  
        //取出其他属性
        $attrModel = M('Attribute');
        // if($attr_id)
            $otherAttr = $attrModel->field('id attr_id,attr_name,attr_type,attr_option_values')->where(array('type_id' => array('eq', $data['type_id']),'id' => array('not in', $attr_id)))->select();
        // else
            // $otherAttr = $attrModel->field('id attr_id,attr_name,attr_type,attr_option_values')->where(array('type_id' => array('eq', $data['type_id'])))->select();
        //把新的属性和原属性合并
        if($otherAttr && $gaData)
        {
            $gaData = array_merge($gaData, $otherAttr);
            usort($gaData, 'attr_id_sort');
        }
        if(empty($gaData))
        {
            $gaData = $otherAttr;
        }    
        $this->assign('gaData', $gaData);

		$this->setPageBtn('修改商品', '商品列表', U('lst?p='.I('get.p')));
		$this->display();
    }
    /**
     * 把商品彻底删除
     */
    public function delete()
    {
    	$model = D('Admin/Goods');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('recyclelst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else 
    	{
    		$this->error($model->getError());
    	}
    }

    /**
     * 把商品放入回收站
     */
    public function recycle()
    {
        $model = M('Goods');
        $model->where(array('id' => array('eq', I('get.id'))))->save(array(
            'is_delete' => 1,
            ));
        $this->success('放入回收站成功！', U('lst', array('p' => I('get.p', 1))));
    }
    /**
     * 展示回收站列表
     * @return [type] [description]
     */
    public function recyclelst()
    {
        $model = D('Admin/Goods');
        $data = $model->search(1);
        $this->assign(array(
            'data' => $data['data'],
            'page' => $data['page'],
        ));

        $this->setPageBtn('商品列表', '商品列表', U('lst'));
        $this->display();
    }
    public function restore(){
        $model = M('Goods');
        $model->where(array('id' => array('eq', I('get.id'))))->save(array(
            'is_delete' => 0,
            ));
        $this->success('还原成功！', U('recyclelst', array('p' => I('get.p', 1))));
    }
    /**
     * 展示商品列表
     */
    public function lst()
    {
        //select a.id,a.goods_name,IFNULL(sum(b.goods_number),0) gn from jn_goods a left join jn_goods_number b on a.id=b.goods_id group by a.id;
    	$model = D('Admin/Goods');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		$this->setPageBtn('商品列表', '添加商品', U('add'));
    	$this->display();
    }

    public function setPageBtn($_page_title = '', $_page_btn_name = '', $_page_btn_link = '#'){
        $this->assign('_page_title', $_page_title);
        $this->assign('_page_btn_name', $_page_btn_name);
        $this->assign('_page_btn_link', $_page_btn_link);
    }

    /**
     * [ajax获得选种类型的属性]
     */
    public function ajaxGetAttr(){
        $typeId = I('get.type_id');
        $attrModel = M('Attribute');
        $attrData = $attrModel->where(array('type_id' => array('eq', $typeId)))->select();
        echo json_encode($attrData);
    }

    public function ajaxDelImage()
    {
        $picId = I('get.pic_id');
        $gpModel = M('GoodsPics');
        //先取出图片的路径
        $picPath = $gpModel->field('pic,sm_pic')->find($picId);
        //删除保存的图片
        deleteImage($picPath);
        //删除数据库中的图片
        $gpModel->delete($picId);
    }

    /**
     * ajax无刷新删除商品属性
     * @return [type] [description]
     */
    public function ajaxDelGoodsAttr(){
        $gaid = I('get.gaid');
        $gaModel = M('GoodsAttr');
        $gaModel->where(array('id' => array('eq', $gaid)))->delete();
    }

    public function goodsNumber(){
        //去除商品id
        $id = I('get.id');
        //到id的数组中得到$rate个
        $gnModel = M('GoodsNumber');
        if(IS_POST)
        {
            //先删除数据库中所有的库存量记录
            $gnModel->where(array('goods_id' => array('eq', $id)))->delete();
            //添加表单中的记录
            $gai = I('post.goods_attr_id');
            $gn = I('post.goods_number');
            $rate = count($gai) / count($gn);
            $_i = 0;
            foreach ($gn as $k => $v) {
                //把每次拿到的id放到数组中
                $_arr = array();
                for($i = 0; $i < $rate; $i++)
                {
                    $_arr[] = $gai[$_i];
                    $_i ++;
                }
                $attr_id = implode(',', $_arr);
                if(!empty($_arr))
                {
                    $gnModel->add(array(
                    'goods_id' => $id,
                    'goods_number' => $v,
                    'goods_attr_id' => $attr_id,
                    ));
                }
            }
            $this->success("设置成功", U('lst', array('p' => I('get.p', 1))));
        }
        //根据id得到同一个属性值有多个的属性值
        //1.取出有多个值得属性ID 2.再取出对应属性ID的记录
        $sql = 'select a.*,b.attr_name from jn_goods_attr a left join jn_attribute b on a.attr_id=b.id where attr_id in (select attr_id from jn_goods_attr where goods_id = '.$id.' group by attr_id having count(*)>1) and goods_id = '.$id;
        $db = M();
        $attrData = $db->query($sql);
        //处理数组,相同属性的放到一起
        $attr = array();
        foreach ($attrData as $k => $v) {
            $attr[$v['attr_id']][] = $v;
        }
        $this->assign('attrData', $attr);

        //取出当前商品已设置的库存量
        $gnData = $gnModel->where(array('goods_id' => array('eq', $id)))->select();
        $this->assign('gnData', $gnData);
        $this->setPageBtn("库存量设置", "商品列表", U('lst', array('p' => I('get.p', 1))));
        $this->display();
    }
}