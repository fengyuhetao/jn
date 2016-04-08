<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class IndexController extends BaseController {

    /**
     * 商品详情页
     * @return [type] [description]
     */
    public function goods(){
        //接收商品id
        $goodsId = I('get.id');
        //取出商品的基本信息
        $goodsModel = M('Goods');
        $info = $goodsModel->find($goodsId);
        $info['addtime'] = date('Y-m-d', $info['addtime']);
        // var_dump($info);

        //取出商品图片
        $gpModel = M('GoodsPics');
        $picData = $gpModel->where(array('goods_id' => array('eq', $goodsId)))->select();

        /********** 取出商品的属性 **********/
        //取出商品的唯一属性
        $gaModel = M('GoodsAttr');
        $gaSingleData = $gaModel->field('a.*, b.attr_name')->alias('a')->join('left join jn_attribute b on a.attr_id = b.id')->where(array('a.goods_id' => array('eq', $goodsId), 'b.attr_type' => array('eq', 0)))->select();

        //取出商品的可选属性
        $gaMultiData = $gaModel->field('a.*, b.attr_name')->alias('a')->join('left join jn_attribute b on a.attr_id = b.id')->where(array('a.goods_id' => array('eq', $goodsId), 'b.attr_type' => array('eq', 1)))->select();
        $arrMultiData = array();
        foreach ($gaMultiData as $k => $v) {
            $arrMultiData[$v['attr_id']][] = $v;
        }

        $this->setPageInfo(array('common', 'jqzoom', 'goods'), array('goods', 'jqzoom-core'), "京商城", $info['seo_keywords'], $info['seo_description'], 0);
        $this->assign(array(
            'info' => $info,    //商品信息
            'picData' => $picData,
            'gaSingleData' => $gaSingleData,
            'gaMultiData' => $arrMultiData,
            ));
        $this->display();
    }

    /**
     * 商城首页
     * @return [type] [description]
     */
    public function index(){
    	$goodsModel = D('Admin/Goods');

    	//获取当前抢购的商品
    	$promoteGoods = $goodsModel->getPromoteGoods();
    	$this->assign('promoteGoods', $promoteGoods);
    	
    	//取出当前最热的商品
    	$hotGoods = $goodsModel->getHotGoods();
    	$this->assign('hotGoods', $hotGoods);
    	
    	//取出当前最新的商品
    	$newGoods = $goodsModel->getNewGoods();
    	$this->assign('newGoods', $newGoods);
    	
    	//取出当前推荐的商品
    	$bestGoods = $goodsModel->getBestGoods();
    	$this->assign('bestGoods', $bestGoods);
    	
    	$this->setPageInfo(array('index'), array('index'), "京商城", '首页', '首页', 1);
    	$this->display();
    }

    /**
     * ajax获取商品价格,并把商品id保存到cookie中
     * @return [type] [description]
     */
    public function ajaxGetData(){
        //计算会员价格
        $goods_id = I('get.goods_id'); 
        $goodsModel = D('Admin/Goods');

        /** 
         * 记录最近浏览
         * 在cookie中保存数组，保存最近的10个
         * cookie无法保存数组，只可保存字符串
         * 必须要序列化(当要把一个复杂的序列类型[数组,对象]持久化(写入文件,或保存到数据库))
         */
        $recentDisplay = isset($_COOKIE['recentDisplay']) ? unserialize($_COOKIE['recentDisplay']) : array();
        //把刚刚浏览的这件商品的ID放到该数组最前面
        array_unshift($recentDisplay, $goods_id);
        //去重
        $recentDisplay = array_unique($recentDisplay);
        //超过10个数据删除
        if(count($recentDisplay) > 10)
            $recentDisplay = array_slice($recentDisplay, 0, 10);
        //把处理好的数组保存回cookie
        $aMonth = 30*24*3600;
        //第四个参数
        // /a/b/c.php中setcookie('name', 'tom')
        // /d.php 中echo $_COOKIE['name']; --> 输出空，读不出来上面定义的cookie，因为cookie默认只有定义在这个cookie的文件所在目录以及子目录下的文件才能访问
        setcookie('recentDisplay', serialize($recentDisplay), time()+$aMonth, '/', 'localhost');
        /**
         * 第五个参数:
         * 扩展:cookie跨域[跨二级域名]
         */

        echo $goodsModel->ajaxMemberPrice($goods_id);
    }

    /**
     * ajax获取最近浏览的商品的信息
     * @return [type] [description]
     */
    public function ajaxGetRecentDisGoods() {
        //从cookie中读取访问的商品id
        $recentDisplay = isset($_COOKIE['recentDisplay']) ? unserialize($_COOKIE['recentDisplay']) : array();
        if($recentDisplay)
        {
            //根据id取出信息
            $goodsModel = M('Goods');
            //默认从数据库中读取数据会按照id升序排列
            //以下代码可以按数组顺序排列
            $recentDisplay_str = implode(',', $recentDisplay);
            $goodsInfo = $goodsModel->field('id, goods_name, sm_logo')->where(array('id' => array('in', $recentDisplay)))->order("INSTR(',$recentDisplay_str,', CONCAT(',',id,','))")->select();
            echo json_encode($goodsInfo);
        }
    }

    /**
     * 获取用户评论
     * @return [type] [description]
     */
    public function ajaxGetComment(){
        $data = array('login' => 0);
        if(session('home_id'))
            $data['login'] = 1;
        echo json_encode($data);
    }
}