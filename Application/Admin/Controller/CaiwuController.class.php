<?php

namespace Admin\Controller;

/**
 * 学生成绩管理
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class CaiwuController extends CommonController
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
		// 调用父类前置方法
		parent::_initialize();

		// 登录校验
		$this->Is_Login();

		// 权限校验
		$this->Is_Power();
	}

	/**
     * [Index 学生成绩列表]
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  0.0.1
     * @datetime 2016-12-06T21:31:53+0800
     */
	public function Index()
	{
		// 参数
		$param = array_merge($_POST, $_GET);

		// 模型对象
		$m = M('Caiwu');

		// 条件
		$where = $this->GetIndexWhere();

		// 分页

		$number = MyC('admin_page_number');
		$total = $m->alias('c')->join('__KEHU__ AS s ON c.kh_id = s.id')->where($where)->count();
		$page_param = array(
				'number'	=>	$number,
				'total'		=>	$total,
				'where'		=>	$param,
				'url'		=>	U('Admin/Caiwu/Index'),
			);
		$page = new \My\Page($page_param);

		// 获取列表
		$field = array('s.username', 'c.*');

		$list = $m->alias('c')->join('__KEHU__ AS s ON c.kh_id = s.id')->where($where)->field($field)->limit($page->GetPageStarNumber(), $number)->order('c.id desc')->select();

		// 数据列表
		$this->assign('list', $this->SetDataHandle($list));

		$this->assign('ht_status_arr',C('ht_status'));
		$this->assign('pay_status_arr',C('pay_status'));

		// 班级
		$this->assign('class_list', $this->GetClassList());

		// 学生成绩等级
		$this->assign('common_fraction_level_list', L('common_fraction_level_list'));

		// 科目
		$subject_list = M('Subject')->field(array('id', 'name'))->where(array('is_enable'=>1))->select();
		$this->assign('subject_list', $subject_list);

		// 成绩期号
		$this->assign('score_list', M('Score')->select());

		// 参数
		$this->assign('param', $param);

		// 分页
		$this->assign('page_html', $page->GetPageHtml());

		// Excel导出地址
		$this->assign('excel_url', U('Admin/Caiwu/ExcelExport', $param));

		// Excel导入基础数据
		$this->assign('excel_import_tips', L('fraction_excel_import_tips'));
		$this->assign('excel_import_form_url', U('Admin/Caiwu/ExcelImport'));
		$this->assign('excel_import_format_url', U('Admin/Caiwu/ExcelExport', ['type'=>'format_download']));

		$this->display('Index');
	}

	/**
	 * [ExcelImport excel导入]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-06T16:48:56+0800
	 */
	public function ExcelImport()
	{
		// 是否ajax请求
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 文件上传校验
		$error = FileUploadError('excel');
		if($error !== true)
		{
			$this->ajaxReturn($error, -1);
		}

		// excel驱动
		$excel = new \My\Excel(array('title'=>L('excel_fraction_import_title_list'), 'msg'=>L('common_not_data_tips')));
		$data = $excel->Import();
		if(empty($data))
		{
			$this->ajaxReturn(L('common_not_data_tips'), -2);
		}

		// 学生成绩对象
		$m = D('FractionImport');

		// 开始处理导入数据
		$success = 0;
		$error = array();
		foreach($data as $k=>$v)
		{
			// 数据处理
			$v = $this->ExcelImportDataDealWith($v);

			// 数据自动校验
			if($m->create($v, 1) !== false)
			{
				// 数据不能重复
				if($this->IsExistData($v['student_id'], $v['subject_id'], $v['score_id']))
				{
					$error[] = $v['username'].' ['.L('common_data_is_exist_error').']';
				} else {
					// 写入数据库
					if($m->add())
					{
						$success++;
					} else {
						$error[] = $v['username'].' ['.L('common_operation_add_error').']';
					}
				}
			} else {
				$error[] = $v['username'].' ['.current($m->getError()).']';
			}
		}
		$this->ajaxReturn(L('common_operation_success'), 0, array('success'=>$success, 'error'=>$error));
	}

	/**
	 * [ExcelImportDataDealWith 学生成绩excel导入数据处理]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-04-07T12:04:05+0800
	 * @param    [array]          $data [学生数据]
	 * @return   [array]                [处理好的数据]
	 */
	private function ExcelImportDataDealWith($data)
	{
		if(!empty($data) && is_array($data))
		{
			// M对象
			$score = M('Score');
			$subject = M('Subject');
			$student = M('Student');

			// 学期号
			$data['semester_id'] = MyC('admin_semester_id');

			// 数据安全处理
			foreach($data as $ks=>$vs)
			{
				$data[$ks] = I('data.'.$ks, '', '', $data);
			}

			// 科目
			if(!empty($data['subject_name']))
			{
				$data['subject_id'] = $subject->where(array('name'=>$data['subject_name']))->getField('id');
				unset($data['subject_name']);
			}

			// 期号
			if(!empty($data['score_name']))
			{
				$data['score_id'] = $score->where(array('name'=>$data['score_name']))->getField('id');
				unset($data['score_name']);
			}

			// 学生
			if(!empty($data['username']) && isset($data['number']) && isset($data['id_card']))
			{
				$data['student_id'] = $student->where(array('username'=>$data['username'], 'number'=>$data['number'], 'id_card'=>$data['id_card'], 'semester_id'=>$data['semester_id']))->getField('id');
				unset($data['number'], $data['id_card']);
			}

			// 添加时间
			if(!empty($data['add_time']))
			{
				$data['add_time'] = strtotime($data['add_time']);
			} else {
				$data['add_time'] = time();
			}
		}
		return $data;
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
				$title = L('excel_fraction_import_title_list');
				$data = array();
				break;

			// 默认按照当前条件查询数据
			default :
			
				$title = L('excel_caiwu_title_list');
				$field = array('s.username', 'c.*');
				$data = $this->SetDataHandle(M('Caiwu')->alias('c')->join('__KEHU__ AS s ON c.kh_id = s.id')->where($this->GetIndexWhere())->field($field)->select());
		}		

		// Excel驱动导出数据
		$excel = new \My\Excel(array('filename'=>'caiwu', 'title'=>$title, 'data'=>$data, 'msg'=>L('common_not_data_tips')));
		$excel->Export();
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


		// $where['c.xx_id']= $_SESSION['xx_id'];

		if($_SESSION['admin']['role_id'] == C('caiwu')){
			$where['c.cw_id']= $_SESSION['admin']['id'];

		}elseif($_SESSION['admin']['role_id'] == C('guwen')){
			$where['c.gw_id']= $_SESSION['admin']['id'];
		}elseif($_SESSION['admin']['role_id'] == C('xuexiao')){
			$where['c.xx_id']= $_SESSION['admin']['id'];
		}else{

		}
		
		// 模糊
		if(!empty($_REQUEST['keyword']))
		{
			$where['s.username'] = array('like', '%'.I('keyword').'%');
		}

		//是否更多条件
		if(I('is_more', 0) == 1)
		{
			// 等值
			if(I('pay_status', 0) > 0)
			{
				$where['c.pay_status'] = intval(I('pay_status'));
			}
			if(I('ht_status', 0) > 0)
			{
				$where['c.ht_status'] = intval(I('ht_status'));
			}
			if(I('kecheng'))
			{
				$where['c.kecheng'] = I('kecheng');
			}

			if(!empty($_REQUEST['time_start']))
			{
				$where['c.ht_start'] = array('gt', I('time_start'));
			}
			if(!empty($_REQUEST['time_end']))
			{
				$where['c.ht_end'] = array('lt', I('time_end'));
			}
		}
		return $where;
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
			$score = M('Score');
			$subject = M('Subject');
			$class = M('Class');
			$score_level = L('common_fraction_level_list');
			foreach($data as $k=>$v)
			{
				// 班级
				$tmp_class = $class->field(array('pid', 'name'))->find($v['class_id']);
				if(!empty($tmp_class))
				{
					$p_name = ($tmp_class['pid'] > 0) ? $class->where(array('id'=>$tmp_class['pid']))->getField('name') : '';
					$data[$k]['class_name'] = empty($p_name) ? $tmp_class['name'] : $p_name.'-'.$tmp_class['name'];
				} else {
					$data[$k]['class_name'] = '';
				}
				
				// 科目
				$data[$k]['subject_name'] = $subject->where(array('id'=>$v['subject_id']))->getField('name');

				// 成绩期号
				$data[$k]['score_name'] = $score->where(array('id'=>$v['score_id']))->getField('name');

				// 成绩等级
				foreach($score_level as $level)
				{
					if($v['score'] >= $level['min'] && $v['score'] <= $level['max'])
					{
						$data[$k]['score_level'] = $level['name'];
					}
				}
				if(!isset($data[$k]['score_level']))
				{
					$data[$k]['score_level'] = '';
				}

				// 添加时间
				$data[$k]['createtime'] = date('Y-m-d H:i', $v['createtime']);
				$data[$k]['updatetime'] = date('Y-m-d H:i', $v['updatetime']);

				// 性别
				$data[$k]['gender'] = L('common_gender_list')[$v['gender']]['name'];

				$data[$k]['ht_status'] = C('ht_status')[$v['ht_status']];
				$data[$k]['pay_status'] = C('pay_status')[$v['pay_status']];
			}
		}
		return $data;
	}

	/**
	 * [SaveInfo 学生成绩添加页面]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function SaveInfo()
	{
		// 参数
		if(empty($_REQUEST['id']))
		{
			$this->error(L('common_param_error'));
		}

		// 学生信息
		$student = M('Kehu')->field(array('id', 'username'))->find(I('id'));
		if(empty($student))
		{
			$this->error(L('fraction_student_error'));
		}
		$caiwu = M('Caiwu')->where(array('kh_id'=>$student['id']))->find();
		$this->assign('data', $caiwu);
		$this->assign('student', $student);

		$this->assign('ht_status',C('ht_status'));
		$this->assign('pay_status',C('pay_status'));
		// 财务

		$this->assign('caiwu_list', $this->get_caiwu_list());

		// 科目
		$this->assign('subject_list', M('Subject')->select());

		$this->display('SaveInfo');
	}

	/**
	 * [Save 学生成绩添加/编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:37:02+0800
	 */
	public function Save()
	{
		// 是否ajax请求
		// if(!IS_AJAX)
		// {
		// 	$this->error(L('common_unauthorized_access'));
		// }

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
	 * [Add 学生成绩添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-18T16:20:59+0800
	 */
	private function Add()
	{

		
		// 学生成绩对象
		$m = M('Caiwu');
		unset($_POST['id']);
		// 数据自动校验
		if($m->create($_POST, 1))
		{
			// 数据不能重复
			if($this->IsExistData(I('kh_id'), I('kecheng')))
			{
				$this->ajaxReturn(L('common_data_is_exist_error'), -2);
			}
	
			// 额外数据处理
			$m->createtime	=	time();
			$m->updatetime	=	time();

			$m->xx_id = $_SESSION['xx_id'];
			$m->gw_id = $_SESSION['admin']['id'];
			$m->pay_status = 0;
			$m->ht_status = 0;
	// 		echo '<pre>';
	// var_dump($m);die;
			// 写入数据库
			if($m->add())
			{
				$this->ajaxReturn(L('common_operation_add_success'));
			} else {
				$this->ajaxReturn(L('common_operation_add_error'), -100);
			}
		} else {
			$this->ajaxReturn($m->getError(), -1);
		}
	}

	/**
	 * [Edit 学生成绩编辑]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-17T22:13:40+0800
	 */
	private function Edit()
	{

		$m = M('Caiwu');
		
		// 数据自动校验
		if($m->create($_POST, 2))
		{
			$m->updatetime	=	time();
			

			// 更新数据库
			if($m->where(array('id'=>I('id'), 'xx_id'=>$_SESSION['xx_id']))->save())
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
	 * [IsExistData 校验数据不能重复添加]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2017-01-08T22:08:46+0800
	 * @return   [boolean] [存在true, 不存在false]
	 */
	private function IsExistData($kehu_id, $kecheng)
	{
		// 数据是否已存在
		$where = array(
				'kh_id'	=>	$kehu_id,
				'kecheng'	=>	$kecheng,
			);
		$tmp = M('Caiwu')->where($where)->getField('id');
		return !empty($tmp);
	}

	/**
	 * [Delete 学生成绩删除]
	 * @author   Devil
	 * @blog     http://gong.gg/
	 * @version  0.0.1
	 * @datetime 2016-12-14T21:40:29+0800
	 */
	public function Delete()
	{
		if(!IS_AJAX)
		{
			$this->error(L('common_unauthorized_access'));
		}

		// 参数是否有误
		if(empty($_POST['id']))
		{
			$this->ajaxReturn(L('common_param_error'), -1);
		}

		$id = $_POST['id'];

		// 删除数据
		if($id != null)
		{
			if(M('Caiwu')->where(array('id'=>$id))->delete())
			{
				$this->ajaxReturn(L('common_operation_delete_success'));
			} else {
				$this->ajaxReturn(L('common_operation_delete_error'), -100);
			}
		} else {
			$this->ajaxReturn(L('common_param_error'), -1);
		}
	}


	public function get_caiwu_list(){
		$where = array();

		// if($_SESSION['admin']['role_id']==C('xuexiao')){
		// 	$where = array('pid'=>$_SESSION['admin']['id'],'role_id'=>C('caiwu'));
		// }elseif($_SESSION['admin']['role_id']==C('guwen')){
		// 	$where = array('pid'=>$_SESSION['admin']['pid'],'role_id'=>C('caiwu'));
		// }
		$where = array('pid'=>$_SESSION['xx_id'],'role_id'=>C('caiwu'));
		if($where){
			return M('Admin')->field('id,username,realname')->where($where)->select();
		}else{
			return false;
		}
		

	}
}
?>