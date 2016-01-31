<?php 
namespace Admin\Controller;
use Think\Controller;

class IndexController extends Controller{
	public function __construct(){
		//判断是否登录
		if(!session('id'))
			redirect(U('Admin/Login/login'));
		parent::__construct();	
	}

	public function index(){
		$this->display();
	}

	public function top(){
		$this->display();
	}

	public function menu(){
		$this->display();
	}

	public function main(){
		$this->display();
	}
}
?>