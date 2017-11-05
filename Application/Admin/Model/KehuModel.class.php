<?php

namespace Admin\Model;
use Think\Model;

/**
 * 学生导入模型
 * @author   Devil
 * @blog     http://gong.gg/
 * @version  0.0.1
 * @datetime 2016-12-01T21:51:08+0800
 */
class KehuModel extends CommonModel
{
	// // 表名
	// protected $tableName = 'kehu';

	// // // 开启批量验证状态
	// protected $patchValidate = true;

	// 数据自动校验
	protected $_validate = array(
		// 添加,编辑
		// 添加
		array('lxrtel_1', 'UniqueTel', '手机号已经存在', 1, 'callback', 1),
		
		// 编辑
		// array('lxrtel_2', '', '手机号2已经存在', 2, 'unique', 1),
		

	);


	 public function UniqueTel()
	 {

		 if(empty($_POST['lxrtel_1']))
		 {
			 return false;
		 }
		 $map = array();
		 $map['lxrtel_1'] = $_POST['lxrtel_1'];
		 // 校验是否唯一
		 $id = $this->db(0)->where($map)->getField('id');
		 return empty($id);
	 }
	 

	
}
?>