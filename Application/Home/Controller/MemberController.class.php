<?php 
namespace Home\Controller;
class MemberController extends BaseController
{
	public function regist()
	{
		if(IS_POST)
		{
			$model = D('Admin/Member');
			if($model->create(I('post.'), 1))
			{
				if($model->add())
				{
					$this->success('注册成功,请登录邮箱验证');
					exit;
				}	
			}
			$this->error($model->getError());
		}
		$this->setPageInfo(array('login'), array('login'), '京商城', '注册页面', '注册页面');
		$this->display();
	}

	public function login()
	{
		if(IS_POST)
		{
			$model = D('Admin/Member');
			if($model->validate($model->_login_validate)->create(I('post.'), 9)){ 
				if(TRUE === $model->login()){
					// $this->success('成功');
					//把cookie中的数据保存到数据库中
					$cartModel = D('Admin/Cart');
					$cartModel->moveCookieToDb();
					//返回到登录前一页
					$returnUrl = session('returnUrl');
					if($returnUrl)
					{
						session('returnUrl', null);
						redirect($returnUrl);
					}
					else
						$this->redirect(MODULE_NAME.'/Index/index');
				}
			}
			$this->error($model->getError());
		}
		$this->setPageInfo(array('login'), array('login'), '京商城', '登录页面', '登录页面');
		$this->display();
	}

	/**
	 * 生成验证码
	 * @return [type] [description]
	 */
	public function chkcode(){
		$Verify = new \Think\Verify(array(
			 'fontSize'    =>    20,    // 验证码字体大小    
			 'length'      =>    2,     // 验证码位数    
			 'useNoise'    =>    false, // 关闭验证码杂点
			));
		$Verify->entry();
	}

	/**
	 * 验证邮箱验证码
	 * @return [type] [description]
	 */
	public function emailchk()
	{
		$code = I('get.code');
		//把这个验证码和数据库中的比较一下
		if($code)
		{
			$model = M('member');
			$email = $model->where(array('email_code' => array('eq', $code)))->find();
			if($email)
			{
				$model->where(array('id' => array('eq', $email['id'])))->setField('email_code', '');
				$this->success('已经完成验证，可以登录', U('login'));
			}
		}	
	}

	/**
	 * 退出登录
	 * @return [type] [description]
	 */
	public function logout()
	{
		session_destroy();
		session_unset();
		// session(null);
		$this->redirect('Home/Index/index');
	}

	/**
	 * ajax判断是否登录
	 * @return [type] [description]
	 */
	public function ajaxChkLogin()
	{
		
		if(session('home_id') >= 0 && !is_null(session('home_id')))
		{
			$arr = array(
				'ok' => 1,
				'email' => session('email'),
				);
		}
		else
		{
			$arr = array(
				'ok' => 0,
				);
		}
		echo json_encode($arr);
	}

	/**
     * 获取上一个页面的地址
     */
    public function saveAndlogin(){
        session('returnUrl', $_SERVER['HTTP_REFERER']);
        echo session('returnUrl');
    }
}
?>