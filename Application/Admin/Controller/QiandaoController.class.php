<?php

namespace Admin\Controller;

/**
 * 学生管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class QiandaoController extends CommonController
{
	/**
	 * [_initialize 前置操作-继承公共前置方法]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-03T12:39:08+0800
	 */
	public function _initialize()
	{
		// // 调用父类前置方法
		parent::_initialize();

		// 登录校验
		$this->Is_Login();

		// 权限校验
		$this->Is_Power();
				
		
		
	}

	/**
     * [Index 学生列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
	
		// 参数
		$param = array_merge($_POST, $_GET);

		$m = M('Qiandao');
		// 条件
		$where = $this->GetIndexWhere();

		// 分页
		$number = MyC('admin_page_number');
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$m->where($where)->count(),
				'where'		=>	$param,
				'url'		=>	U('Admin/Qiandao/Index'),
			);

		$page = new \My\Page($page_param);
		$res = $this->SetDataHandle($m->where($where)->limit($page->GetPageStarNumber(), $number)->order('id desc')->select());
		$this->assign('list',$res);


		$this->display('Index');
	}
	



	/**
	 * [ExcelExport excel文件导出]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-10T15:46:00+0800
	 */
	public function ExcelExport()
	{
		// 类型
		switch(I('type'))
		{
			// 格式下载类型不查询数据,只导出标题格式
			case 'format_download' :
				$title = L('excel_student_impoet_title_list');
				$data = array();
				break;

			// 默认按照当前条件查询数据
			default :
				$title = L('excel_student_title_list');
				$data = $this->SetDataHandle(M('Student')->where($this->GetIndexWhere())->select());
		}

		// Excel驱动导出数据
		$excel = new \My\Excel(array('filename'=>'student', 'title'=>$title, 'data'=>$data, 'msg'=>L('common_not_data_tips')));
		$excel->Export();
	}

	/**
	 * [SetDataHandle 数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-29T21:27:15+0800
	 * @param    [array]      $data [学生数据]
	 * @return   [array]            [处理好的数据]
	 */
	private function SetDataHandle($data)
	{
		if(!empty($data))
		{
			$c = M('Class');
			$r = M('Region');
			foreach($data as $k=>$v)
			{
				// 班级
				$tmp_class = $c->field(array('pid', 'name'))->find($v['class_id']);
				if(!empty($tmp_class))
				{
					$p_name = ($tmp_class['pid'] > 0) ? $c->where(array('id'=>$tmp_class['pid']))->getField('name') : '';
					$data[$k]['class_name'] = empty($p_name) ? $tmp_class['name'] : $p_name.'-'.$tmp_class['name'];
				} else {
					$data[$k]['class_name'] = '';
				}
				
				// 姓名
				$data[$k]['username'] = M('Xuesheng')->where(array('id'=>$v['uid']))->getField('username');

				// 出生
				if(!empty($data[$k]['birthday'])){
					$data[$k]['age'] = calcAge($data[$k]['birthday']);
				}

				// 报名时间
				$data[$k]['createtime'] = date('Y-m-d H:i', $v['createtime']);

				// 更新时间
				$data[$k]['updatetime'] = date('Y-m-d H:i', $v['updatetime']);

				// 性别
				$data[$k]['sex'] = L('common_gender_list')[$v['sex']]['name'];

				// 状态
				$data[$k]['state'] = L('common_student_state_list')[$v['state']]['name'];

				// 缴费状态
				$data[$k]['tuition_state'] = L('common_tuition_state_list')[$v['tuition_state']]['name'];
			}
		}
		return $data;
	}

	/**
	 * [GetIndexWhere 学生列表条件]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-10T22:16:29+0800
	 */
	private function GetIndexWhere()
	{
		$where = array();

		if($_SESSION['admin']['role_id'] != 1){
			if($_SESSION['admin']['role_id'] == C('laoshi')){
				$where['pid']= $_SESSION['admin']['id'];
	
			}elseif($_SESSION['admin']['role_id'] == C('xuexiao')){
				$where['xx_id']= $_SESSION['admin']['id'];
			}elseif($_SESSION['admin']['role_id'] == C('caiwu') || $_SESSION['admin']['role_id'] == C('guwen') ){
				$where['xx_id'] = $_SESSION['xx_id'];
			}else{
	
			}
		}
		



		// 模糊
		if(!empty($_REQUEST['keyword']))
		{
			$like_keyword = array('like', '%'.I('keyword').'%');
			$where[] = array(
					// 'username'		=>	$like_keyword,
					'uid'		=>	$like_keyword,
					'_logic'		=>	'or',
				);
		}

		// 是否更多条件
		if(I('is_more', 0) == 1)
		{
			
			if(I('status', -1) > -1)
			{
				$where['status'] = intval(I('status', 0));
			}
			

			// 表达式
			if(!empty($_REQUEST['time_start']))
			{
				$where['updatetime'][] = array('gt', strtotime(I('time_start')));
			}
			if(!empty($_REQUEST['time_end']))
			{
				$where['updatetime'][] = array('lt', strtotime(I('time_end')));
			}
		}


		return $where;
	}

	/**
	 * [SaveInfo 学生添加/编辑页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{	
		$data = array();
		if(!empty($_REQUEST['id'])){
			$data = M('Qiandao')->where(array('id'=>$_REQUEST['id']))->find();
		}

		$this->assign('xuesheng_list',$this->get_xuesheng());

		$this->assign('data', $data);
	
		$this->display('SaveInfo');
	}

	/**
	 * [Save 学生添加/编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function Save()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 添加
		if(empty($_POST['id']))
		{
			$this->Add();

		// 编辑
		} else {
			$this->Edit();
		}
	}

	/**
	 * [Add 学生添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{
		// 学生模型
		$m = 	M('Xuesheng');

		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 额外数据处理
			// $m->add_time	=	time();
			// $m->birthday	=	strtotime($m->birthday);
			// $m->semester_id	=	MyC('admin_semester_id');
			// $m->username 	=	I('username');
			// $m->address 	=	I('address');
			$m->pid = $_SESSION['admin']['id'];
			$m->xx_id = $_SESSION['xx_id'];
			$m->createtime = time();
			$m->updatetime = time();
			
			// 开启事务
			$m->startTrans();
			// // 学生是否已存在编号
			// $number = $m->where(array('id_card'=>I('id_card')))->getField('number');

			// 数据写入
			$student_id = $m->add();

			if($student_id)
			{
				// 提交事务
				$m->commit();
				$this->ajaxReturn(L('common_operation_add_success'));
			} else {
				// 回滚事务
				$m->rollback();
				$this->ajaxReturn(L('common_operation_add_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Edit 学生编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{
		// 学生模型
		$m = M('Qiandao');

		// 数据自动校验
		if($m->create($_POST, 2))
		{
			//额外数据处理
			if(!empty($m->updatetime))
			{
				$m->updatetime	=	strtotime($m->updatetime);
			}

			$m->pid = $_SESSION['admin']['id'];
			$m->xx_id = $_SESSION['xx_id'];
			
			// 移除不能更新的数据
			// unset($m->id_card, $m->number);

			// 更新数据库
			if($m->where(array('id'=>I('id'),'xx_id'=>$_SESSION['xx_id']))->save())
			{
				$this->ajaxReturn(L('common_operation_edit_success'));
			} else {
				$this->ajaxReturn(L('common_operation_edit_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Delete 学生删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-15T11:03:30+0800
	 */
	public function Delete()
	{
		
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		
		$id = I('id');
		// 删除数据
		if($id != null)
		{
			// 学生模型
			$s = M('Qiandao');

			// 学生是否存在
			$student = $s->where(array('id'=>$id, 'xx_id'=>$_SESSION['xx_id']))->getField('id');
			if(empty($student))
			{
				$this->ajaxReturn('该数据不存在', -2);
			}

			// 开启事务
			$s->startTrans();

			// 删除学生
			$s_state = $s->where(array('id'=>$id, 'xx_id'=>$_SESSION['xx_id']))->delete();

			
			if($s_state !== false )
			{
				// 提交事务
				$s->commit();

				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				// 回滚事务
				$s->rollback();
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn(L('common_param_error'), -1);
		}
	}

	public function Qiandao()
	{
		
	
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		
		$id = I('id');
		// 删除数据
		if($id != null)
		{
			// 学生模型
			$s = M('Xuesheng');

			// 学生是否存在
			$student = $s->where(array('id'=>$id, 'xx_id'=>$_SESSION['xx_id']))->getField('id');
			if(empty($student))
			{
				$this->ajaxReturn(L('student_no_exist_error'), -2);
			}
			$q = M('Qiandao');
			$data = array();
			// 开启事务
			// $s->startTrans();
			$qdsum = $q->where(array('uid'=>$id,'xx_id'=>$_SESSION['xx_id'],'status'=>1))->count();
			if($qdsum > 0){
				$qddata = $q->where(array('uid'=>$id,'xx_id'=>$_SESSION['xx_id'],'status'=>1))->order('updatetime desc')->limit('1')->find();
				$j = strtotime(date('Y-m-d',time()));//今天
				$z = strtotime(date('Y-m-d',$qddata['updatetime']));//最好一次
				$t = ($j-$z)/(3600*24);//多少天
				if($t < 1){
					$this->ajaxReturn('今天已经签到过了');die;
				}

			}

			$data['uid'] = $id;
			$data['updatetime'] = time();
			$data['status'] = 1;
			$data['pid'] = $_SESSION['admin']['id'];
			$data['xx_id'] = $_SESSION['xx_id'];
			$res = $q->add($data);
			


			
			if($res != false )
			{
				// 提交事务
				// $s->commit();

				$this->ajaxReturn('签到成功');
			} else {
				// 回滚事务
				// $s->rollback();
				$this->ajaxReturn('签到失败，请重试', -100);
			}
		} else {
			$this->ajaxReturn('网络错误', -1);
		}
	}

	public function get_guwen(){

		$where = array();
		$where['role_id'] = C('guwen');
		if($_SESSION['admin']['role_id'] == C('guwen')){
			$where['id']= $_SESSION['admin']['id'];

		}elseif($_SESSION['admin']['role_id'] == C('xuexiao')){
			$where['pid']= $_SESSION['admin']['id'];
		}elseif($_SESSION['admin']['role_id'] == C('caiwu')){
			$where['pid'] = $_SESSION['xx_id'];
		}else{

		}


		$res = M('Admin')->where($where)->order('id asc')->select();
		return $res;
	}

	public function get_laoshi(){

		$where = array();
		$where['role_id'] = C('laoshi');
		if($_SESSION['admin']['role_id'] == C('laoshi')){
			$where['id']= $_SESSION['admin']['id'];

		}elseif($_SESSION['admin']['role_id'] == C('xuexiao')){
			$where['pid']= $_SESSION['admin']['id'];
		}elseif($_SESSION['admin']['role_id'] == C('caiwu')){
			$where['pid'] = $_SESSION['xx_id'];
		}else{

		}


		$res = M('Admin')->where($where)->order('id asc')->select();
		return $res;
	}
	public  function get_kecheng(){
		$id = $_SESSION['admin']['id'];

		$res = M('Subject')->field('id,name')->where(array('is_enable'=>1))->order('id asc')->select();


		return $res;
	}	

	public function get_xuesheng(){
		if($_SESSION['admin']['role_id'] == C('laoshi')){
			$where['ls_id']= $_SESSION['admin']['id'];
		}
		$res = M('Xuesheng')->where($where)->select();

		return $res;
	}
}
?>