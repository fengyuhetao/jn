<?php 
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model
{
	//注册时允许提交的表单
	protected $insertFields = array('email', 'password', 'cpassword', 'chkcode', 'mustClick');

	// 登录时表单验证的规则 
	public $_login_validate = array(
		array('email', 'require', '用户名不能为空！', 1),
		array('email', 'email', 'email格式不正确'),
		array('password', 'require', '密码不能为空！', 1),
		array('password', '6,20', '密码必须是6-20位字符', 1, 'length'),
		array('chkcode', 'require', '验证码不能为空！', 1),
		array('chkcode', 'chk_chkcode', '验证码不正确！', 1, 'callback'),
	);

	//注册时的表单验证规则
	protected $_validate = array(
		array('mustClick', 'require', '同意注册协议才行', 1),
		array('email', 'require', 'email不能为空'),
		array('email', 'email', 'email格式不正确'),
		array('password', 'require', '密码不能为空'),
		array('password', '6,20', '密码必须是6-20位字符', 1, 'length'),
		array('cpassword', 'password', '两次密码输入不一致', 1, 'confirm'),
		array('chkcode', 'require', '验证码不能为空'),
		array('chkcode', 'chk_chkcode', '验证码不正确', 1, 'callback'),
		array('email', '', 'email已经被注册过了', 1, 'unique'),
		);

	public function chk_chkcode($code)
	{
		 $verify = new \Think\Verify();
		 return $verify->check($code);
	}

	protected function _before_insert(&$data, $option)
	{
		//注册时间
		$data['addtime'] = time();
		//生成验证email用的验证码
		$data['email_code'] = md5(uniqid());
		$data['password'] = md5($data['password'].C('MD5_KEY'));
	}

	protected function _after_insert($data, $option)
	{
		$content = <<<HTML
		<p>欢迎您成为本站的会员，请点击一下链接完成email验证.</p>
		<p><a href = "http://localhost/jn/index.php/Home/Member/emailchk/code/{$data['email_code']}">点击完成验证</p>
HTML;
		//发送邮件给用户
		sendMail($data['email'], 'email验证', $content);
	}

	public function login()
	{
		$email = $this->email;
		$password = $this->password;
		$user = $this->where(array('email' => array('eq', $email)))->find();
		if($user) 
		{
			//判断是否通过email验证
			if(empty($user['email_code']))
			{
				if($user['password'] == md5($password.C('MD5_KEY')))
				{
					session('home_id', $user['id']);
					session('email', $user['email']);
					session('jyz', $user['jyz']);
					// 算出所在级别ID
					$mlModel = M('MemberLevel');
					$ml = $mlModel->field('id, rate')->where(" {$user['jifen']} between bottom_num and top_num ")->find();
					session('level_id', $ml['id']);
					session('rate', $ml['rate']);
					return TRUE;
				}
				else
				{
					$this->error = "密码不正确";
					return false;
				}
			}
			else
			{
				$this->error = "账号还没有通过email验证";
				return false;
			}
		}
		else
		{
			$this->error = "账号不存在";
			return false;
		}
	}
}
?>