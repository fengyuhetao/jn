<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
class CartController extends BaseController {
    public function add()
    {
        $cartModel = D('Admin/Cart');
        $goods_attr_id = I('post.goods_attr_id');
        if($goods_attr_id)
        {   
            //后台数据库的库存量是升序的
            sort($goods_attr_id);
            $goods_attr_id = implode(',', I('post.goods_attr_id'));
        }      
        $cartModel->addToCart(I('post.goods_id'), $goods_attr_id, I('post.goods_number'));
        redirect(U('lst'));
    }

    public function lst()
    {
        $cartModel = D('Admin/Cart');
        $data = $cartModel->cartList();
        $this->assign('cart_data', $data);
        $this->setPageInfo(array('cart'), array('cart1'), "京商城", '购物车', '购物车', 0);
        $this->display();
    }

    public function ajaxUpdateCartData()
    {
        $goods_id = I('get.goodsId');
        $gaid = I('get.gaid');
        $goods_number = I('get.goods_number');
        $cartModel = D('Admin/Cart');
        $cartModel->updateData($goods_id, $gaid, $goods_number);
    }

    public function order()
    {
        /********** 把用户选择的商品保存到session中，如果没有选择，则不能进入该页面 *********/
        $buythis = I('post.buythis');
        //如果表单中没有选择，并且session也没有保存
        if(!$buythis)
        {    
            $buythis = session('buythis');
            if(!$buythis)
            {
                $this->error('必须选择其中一个商品');
            }   
        }
        else
        {
            session('buythis', $buythis);
        }    
        $mid = session('home_id');
        //如果会员没有登录，跳到登录页面
        if(!$mid)
        {
            session('returnUrl', U('order'));
            redirect(U('Home/Member/login'));
        }

        if(IS_POST && !isset($_POST['buythis']))
        {
            $orderModel = D('Admin/Order');
            if($orderModel->create(I('post.'), 1))
            {
                if($id = $orderModel->add())
                {
                    $this->success('下单成功', U('orderOk?order_id='.$id));
                    exit;
                }
            }
            $this->error($orderModel->getError());
        }
        //显示表单
        $cartModel = D('Admin/Cart');  
        $data = $cartModel->cartList();
        $this->assign('cart_data', $data);
        $this->setPageInfo(array('fillin'), array('cart2'), "京商城", '下订单', '下订单', 0);
        $this->display();
    }

    //下单成功后的页面
    public function orderOk()
    {
        $id = I('get.order_id');
        //查询该订单的总价
        $orderModel = M('Order');
        $tp = $orderModel->field('total_price')->where(array('id' => array('eq', $id)))->find();
        /*********************生成支付宝按钮 ***********************/
        require_once("./alipay/alipay.config.php");
        require_once("./alipay/lib/alipay_submit.class.php");

        /**************************请求参数**************************/

        //支付类型
        $payment_type = "1";
        //必填，不能修改
        
        //服务器异步通知页面路径 - 我们用来接收支付宝发来的消息地址
        $notify_url = "http://localhost/jn/index.php/Home/Cart/respond";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径 - 会员在支付成功后跳转到该页面
        $return_url = "http://localhost/jn/index.php/Home/Cart/success";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //商户订单号 - 本地的订单号
        $out_trade_no = $id;
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = '本地支付';
        //必填

        //付款金额
        $total_fee = $tp['total_price'];
        //必填

        //订单描述
        $body = '本地支付';
       
        //商品展示地址 - 显示购买商品的详情页面 -可再写一个函数，展示订单中所有的商品
        $show_url = $_POST['WIDshow_url'];
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = "";
        //若要使用请调用类文件submit中的query_timestamp函数

        //客户端的IP地址
        $exter_invoke_ip = get_client_ip();
        //非局域网的外网IP地址，如：221.0.0.1

        /************************************************************/
        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => trim($alipay_config['partner']),
            "seller_email" => trim($alipay_config['seller_email']),
            "payment_type"  => $payment_type,
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "out_trade_no"  => $out_trade_no,
            "subject"   => $subject,
            "total_fee" => $total_fee,
            "body"  => $body,
            "show_url"  => $show_url,
            "anti_phishing_key" => $anti_phishing_key,
            "exter_invoke_ip"   => $exter_invoke_ip,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        // 生成按钮的html代码
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "去支付宝支付");


        $this->assign('pay_btn', $html_text);
        $this->setPageInfo(array('success'), array(), "京商城", '下订单成功', '下订单成功', 0);
        $this->display();
    }

    /**
     * 接收支付宝发来的消息
     * @return [type] [description]
     */
    public function respond()
    {
        //执行notify_url.php文件中的代码
        // include('./alipay/notify_url.php');
        require_once("./alipay/alipay.config.php");
        require_once("./alipay/lib/alipay_notify.class.php");

        //计算得出通知验证结果
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        if($verify_result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代

            
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            
            //商户订单号 - 本地订单号
            $out_trade_no = $_POST['out_trade_no'];

            //支付宝交易号 - 在支付宝上的交易号
            $trade_no = $_POST['trade_no'];

            //交易状态 - 不同的借口有不同的状态 比如（用的时担保交易，收到货，已付款等），我们用的是及时到账，只有一个支付成功的状态
            $trade_status = $_POST['trade_status'];

            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                    //如果有做过处理，不执行商户的业务程序
                    
                //设置该订单为已支付的状态
                $orderModel = D('Admin/Order');
                $orderModel->setPaid($out_trade_no);

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
                    //如果有做过处理，不执行商户的业务程序
                        
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知

                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                
            echo "success";     //请不要修改或删除
            
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }
    }

    /**
     * 会员支付成功后跳转到该页面
     * @return [type] [description]
     */
    public function success()
    {

    }
}