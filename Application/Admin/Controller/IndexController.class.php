<?php 
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller{
	public function __construct(){
		//调用父类的构造方法
		parent::__construct();	

		//判断是否登录
		$adminId = session('id');
		
		if(empty($adminId))
		{
			redirect(U('Admin/Login/login'));
		}

		//判断用户是否有权限访问该页面
		//1.先获取当前管理员将要访问的页面 TP自带三个常量
		$url = MODULE_NAME .' / '. CONTROLLER_NAME .' / '. ACTION_NAME;
		$where = 'module_name = "' .MODULE_NAME. '" and controller_name = "' .CONTROLLER_NAME. '" AND action_name= "'.ACTION_NAME.'"';
		if($adminId == 1){
			return true;
		}else{
			$sql = 'select count(*) count from jn_role_privilege a left join jn_privilege b on a.pri_id=b.id left join jn_admin_role c on a.role_id=c.role_id where c.admin_id='.$adminId.' and '.$where;
		}
		$db = M();
		$is_exist = $db -> query($sql);
		// echo $sql;
		// echo "<br/>";
		// echo $is_exist[0]['count'];
		// die;

		//如果控制器是Index,则可以直接访问
		if(CONTROLLER_NAME == 'Index')
		{
			return true;
		}	

		if($is_exist[0]['count'] < 1)
		{
			$this->error("没有权限访问该页面");
		}
	}

	public function index(){
		$this->display();
	}

	public function top(){
		$this->display();
	}

	public function menu(){
		//取出当前管理员所拥有的前两级按钮
		$adminId = session('id');
		if($adminId == 1){
			$sql = 'select * from jn_privilege';
		}else{
			$sql = 'select b.* from jn_role_privilege a left join jn_privilege b on a.pri_id=b.id left join jn_admin_role c on a.role_id=c.role_id where c.admin_id='.$adminId.' group by b.pri_name';
		}
		$db = M();
		$menu = $db -> query($sql);
		//从所有权限中取出前两级的权限
		foreach ($menu as $k => $v) {
			# code...
			if($v['parent_id'] == 0)
			{
				foreach ($menu as $k1 => $v1) {
					# code...
					if($v1['parent_id'] == $v['id'])
					{
						$v['children'][] = $v1;
					}
				}
				$btn[] = $v;
			}
		}
		$this->assign('btn', $btn);
		$this->display();
	}

	public function main(){
		$this->display();
	}
}
?>