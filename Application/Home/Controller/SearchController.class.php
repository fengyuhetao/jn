<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class SearchController extends BaseController {
    public function search()
    {	      
    	//取出商品属性表
    	$gaid = I('get.cid');
        $goodsModel = D('Admin/Goods');

        //到缓存中看有没有价格区间的缓存
        $_price = S('price_'.$gaid);
        if(!$_price)
        {
            //计算这个分类下商品的额七个价格区间的范围
            //算法:取出这个分类下商品的最低价和最高价，然后分七段 
            $priceSection = 7; //要分的段数
            $price = $goodsModel->field('MIN(shop_price) minprice, MAX(shop_price) maxprice')->where(array('cate_id' => array('eq', $gaid)))->find();
           
            //最低价和最高价分七段
            $_price = array();
            //计算每个段应该价格区间
            $sprice = ceil(($price['maxprice'] - $price['minprice']) / $priceSection);
            $firstPrice = floor($price['minprice']/10)*10;
            for($i = 0; $i < $priceSection; $i++)
            {
                $start = floor($firstPrice/10)*10;
                if($i == $priceSection - 1)
                    $end = floor(($firstPrice + $sprice)/10)*10;
                else
                    $end = (floor(($firstPrice + $sprice)/10)*10-1);
                $firstPrice += $sprice;
                //先判断这个价格段是否有商品
                $goodsCount = $goodsModel->where(array(
                    'shop_price' => array('between', array($start, $end)), 
                    'cate_id' => array('eq', $gaid), 
                    'is_on_sale' => array('eq', '1'), 
                    'is_delete' => array('eq', 0)
                    ))->count();
                if($goodsCount == 0)
                    continue;
                else
                    $_price[] = $start .'-'. $end;

            }
            S('price_'.$gaid, $_price);
        }
        //先读缓存
        $attrData = S('attrData_'.$gaid);
        if(!$attrData)
        {
            $catModel = M('Category');
            $searchAttrData = $catModel->field('search_attr_id')->find($gaid);
            $attrModel = M('Attribute');
            $attrData = $attrModel->field('attr_name, id')->where(array('id' => array('in', $searchAttrData['search_attr_id'])))->select();
            //循环所有的筛选属性，取出这些属性中有商品的值
            $gaModel = M('GoodsAttr');
            foreach ($attrData as $k => $v) {
            	//找出这个属性有商品的值 -->从商品属性表
            	$attrValues = $gaModel->field('DISTINCT attr_value')->where(array('attr_id' => array('eq', $v['id'])))->select();
            	if(!$attrValues)
            		unset($attrData[$k]);
                else
            		$attrData[$k]['attr_value'] = $attrValues;
            }
            S('attrData_'.$gaid, $attrData);
        }
        	// $this->assign('searchAttrData', $searchAttrData);
        //调用search_goods 方法
        $goods_search = $goodsModel->search_goods(); 
        $this->assign('goods_search', $goods_search);
        $this->assign('price', $_price, 1800); 
        $this->assign('attrData', $attrData, 1800);
        $this->setPageInfo(array('list', 'common'), array('list'), '京商城', '列表页', '列表页', 0);
        $this->display();
    }
}