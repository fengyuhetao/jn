<?php 
namespace Home\Controller;
/**
 * 评论类
 */
class CommentController extends BaseController
{
	public function add()
	{
		//判断是否登录
		$mid = session('home_id');
		if(!$mid && $mid !== '0')
		{	
			echo json_encode(array(
				'ok' => 0,
				'error' => '请先登录',	
				));
		}
		if(IS_POST)	
		{
			$model = D('Admin/Comment');
			if($model->create(I('post.'), 1))
			{
				if($model->add())
				{
					//取出会员头像
					$memberModel = M('Member');
					$face = $memberModel->field('face')->find($mid);
					//如果没有头像，设置默认头像
				//	$face = !$face['face'] ? 'default_face.jpg' : $face['face'];
					// if(!$face)
					// 	$face = 'default_face.jpg';
					echo json_encode(array(
						'ok' => 1,
						'content' => I('post.content'),//过滤之后的内容
						'addtime' => date('Y-m-d H:m'),
						'star' => I('post.star'), 
						'email' => session('email'),
						'face' => $face['face'],
					));
				}
				else 
				{
					echo json_encode(array(
						'ok' => 0,
						'error' => $model->getError(),
					));
				}
			}
			else
				echo json_encode(array(
				'ok' => 0,
				'error' => $model->getError(),
			));
		}
	}

	public function ajaxGetComment()
	{
		//每页显示条数
		$perpage = 5;
		$p = I('get.p');
		$offset = ($p - 1)*$perpage; //从第几条记录开始取数据
		$goodsId = I('get.goods_id');
		$comment = M('Comment');
		$data = $comment->alias('a')->field('a.*, b.email, b.face, count(c.id) reply_count')->join('left join jn_member b on a.member_id=b.id left join jn_reply c on a.id=c.comment_id')->where(array('a.goods_id' => array('eq', $goodsId)))->group('a.id')->limit("$offset,$perpage")->select();
		foreach ($data as $k => $v) {
			$data[$k]['face'] = $v['face'] ? '/Public/Home/'.$v['face'] : '/Public/Home/image/default_face.jpg';
			$data[$k]['addtime'] = date('Y-m-d H:i', $v['addtime']);
		}
		echo json_encode($data);
	}
}
?>