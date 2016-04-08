<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
	/**
	 * 设置页面信息
	 * @param [string] $title       [设置页面标题]
	 * @param [string] $keywords    [设置页面关键字]
	 * @param [string] $description [设置页面描述]
	 * @param [int]    $showNav     [设置导航栏是否展开]
	 * @param array    $css         [设置页面中的css文件]
	 * @param array    $js          [设置页面中的js文件]
	 */
	public function setPageInfo($css = array(), $js = array(), $title = "京商城", $keywords = "", $description = "", $showNav = 0)
	{
		if($showNav == 0 || $showNav == 1)
		{
			$this->assign('nav', $showNav);
		}	
    	$this->assign('page_title', $title);
    	if(!empty($css))
    	{
    		$this->assign('page_css', $css);
		}	
    	if(!empty($js))
    	{
    		$this->assign('page_js', $js);
    	}	
    	$this->assign('page_keywords', $keywords);
    	$this->assign('page_description', $description);
	}
}