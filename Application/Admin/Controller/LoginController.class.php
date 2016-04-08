<?php 
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{
	/**
	 * 登录页面显示或判断登录情况
	 * @return 
	 */
	public function login(){
		if(IS_POST){
			$model = D('Admin');
			//1.代表添加(默认) 2.代表修改 填其他的数即可 9 自己规定，代表该表单是登录表单
			if($model->validate($model->_login_validate)->create('', 9)){ 
				if(TRUE === $model->login()){
					$this->redirect(MODULE_NAME.'/Index/index');  //直接跳转
					//redirect(U('Admin/Index/index'));  //直接跳转
				}
			}
			$this->error($model->getError());
		}
		$this->display();
	}

	public function chkcode(){
		$Verify = new \Think\Verify(array(
			 'fontSize'    =>    20,    // 验证码字体大小    
			 'length'      =>    2,     // 验证码位数    
			 'useNoise'    =>    false, // 关闭验证码杂点
			));
		$Verify->entry();
	}

	/**
	 * 退出登录
	 * @return [type] [description]
	 */
	public function logout(){
		session_destroy();
		session_unset();
		$this->redirect('login');
	}
}
?>