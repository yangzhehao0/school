<?php if (!defined('THINK_PATH')) exit();?><!-- header start -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php echo C('DEFAULT_CHARSET');?>" />
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1">
	<title><?php echo L('common_site_title');?></title>
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/assets/css/amazeui.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/amazeui-switch/amazeui.switch.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Lib/amazeui-chosen/amazeui.chosen.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Common/Css/Common.css" />
	<link rel="stylesheet" type="text/css" href="/Public/Admin/<?php echo ($default_theme); ?>/Css/Common.css" />
	<?php if(!empty($module_css)): ?><link rel="stylesheet" type="text/css" href="/Public/<?php echo ($module_css); ?>" /><?php endif; ?>
</head>
<body>
<!-- header end -->

<!-- right content start  -->
<div class="content-right">
	<div class="content">
		<!-- form start -->
		<form class="am-form form-validation view-save" action="<?php echo U('Admin/Xuesheng/Save');?>" method="POST" request-type="ajax-url" request-value="<?php echo U('Admin/Xuesheng/Index');?>">
			<legend>
				<span class="fs-16">
					<?php if(empty($data['id'])): ?>添加学生	
					<?php else: ?>
						编辑学生<?php endif; ?>
				</span>
				<a href="<?php echo U('Admin/Kehu/Index');?>" class="fr fs-14 m-t-5 am-icon-mail-reply"> <?php echo L('common_operation_back');?></a>
			</legend>
			<div class="am-form-group">
				<label><?php echo L('student_username_text');?></label>
				<input type="text" name="username" placeholder="<?php echo L('student_username_text');?>" minlength="2" maxlength="16" data-validation-message="<?php echo L('student_username_format');?>" class="am-radius" <?php if(!empty($data)): ?>value="<?php echo ($data["username"]); ?>"<?php endif; ?> required />
			</div>

			
			<!-- 性别 开始 -->
<div class="am-form-group">
	<label><?php echo L('common_view_gender_name');?></label>
	<div>
		<?php if(is_array($common_gender_list)): foreach($common_gender_list as $key=>$v): ?><label class="am-radio-inline m-r-10">
				<input type="radio" name="sex" value="<?php echo ($v["id"]); ?>" <?php if(isset($data['sex']) and $data['sex'] == $v['id']): ?>checked="checked"<?php else: if(!isset($data['sex']) and isset($v['checked']) and $v['checked'] == true): ?>checked="checked"<?php endif; endif; ?> data-am-ucheck /> <?php echo ($v["name"]); ?>
			</label><?php endforeach; endif; ?>
	</div>
</div>
<!-- 性别 结束 -->

			<div class="am-form-group">
				<label><?php echo L('student_birthday_text');?></label>
				<input type="text" name="birthday" class="am-radius" placeholder="<?php echo L('student_birthday_text');?>" pattern="<?php echo L('common_regex_birthday');?>" data-validation-message="<?php echo L('student_birthday_format');?>" <?php if(!empty($data)): ?>value="<?php echo ($data["birthday"]); ?>"<?php endif; ?> data-am-datepicker="{format: 'yyyy-mm-dd', viewMode: 'years'}" readonly required />
			</div>
			<div class="am-form-group">
				<label>联系人姓名</label>
				<input type="text" name="lxr_1" class="am-radius" placeholder="联系人姓名" data-validation-message="联系人姓名" <?php if(!empty($data)): ?>value="<?php echo ($data["lxr_1"]); ?>"<?php endif; ?> required />
			</div>
			<div class="am-form-group">
				<label>联系人电话</label>
				<input type="text" name="lxrtel_1" class="am-radius" placeholder="联系人电话" data-validation-message="联系人电话" <?php if(!empty($data)): ?>value="<?php echo ($data["lxrtel_1"]); ?>"<?php endif; ?> required />
			</div>
			<div class="am-form-group">
				<label>联系人姓名2</label>
				<input type="text" name="lxr_2" class="am-radius" placeholder="联系人姓名" data-validation-message="联系人姓名" <?php if(!empty($data)): ?>value="<?php echo ($data["lxr_2"]); ?>"<?php endif; ?>  />
			</div>
			<div class="am-form-group">
				<label>联系人电话2</label>
				<input type="text" name="lxrtel_2" class="am-radius" placeholder="联系人电话" data-validation-message="联系人电话" <?php if(!empty($data)): ?>value="<?php echo ($data["lxrtel_2"]); ?>"<?php endif; ?>  />
			</div>
			<div class="am-form-group">
				<label>课程</label>
				<select  class="am-radius c-p" name="kecheng" >
					<option value="0"><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($kecheng)): foreach($kecheng as $key=>$v): ?><option value="<?php echo ($v["name"]); ?>" <?php if(isset($data['kecheng']) and $data['kecheng'] == $v['name']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>课程顾问</label>
				<select  class="am-radius c-p" name="gw_id" >
					<option value="0"><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($guwen)): foreach($guwen as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(isset($data['gw_id']) and $data['gw_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["realname"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>授课老师</label>
				<select  class="am-radius c-p" name="ls_id" >
					<option value="0"><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($laoshi)): foreach($laoshi as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(isset($data['ls_id']) and $data['ls_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["realname"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>课程时长</label>
				<input type="text" name="kc_sc" class="am-radius" placeholder="课程时长" data-validation-message="课程时长" <?php if(!empty($data)): ?>value="<?php echo ($data["kc_sc"]); ?>"<?php endif; ?>  />
			</div>
			

			<input type="hidden" name="id" <?php if(!empty($data)): ?>value="<?php echo ($data["id"]); ?>"<?php endif; ?> />
			<input type="hidden" name="kh_id" <?php if(!empty($data)): ?>value="<?php echo ($data["kh_id"]); ?>"<?php endif; ?> />
			<input type="hidden" name="cw_id" <?php if(!empty($data)): ?>value="<?php echo ($data["cw_id"]); ?>"<?php endif; ?> />
			<!-- <div class="am-form-group">
				<label><?php echo L('student_tuition_state_text');?></label>
				<div>
					<?php if(is_array($common_tuition_state_list)): foreach($common_tuition_state_list as $key=>$v): ?><label class="am-radio-inline m-r-10">
							<input type="radio" name="tuition_state" value="<?php echo ($v["id"]); ?>" <?php if(isset($data['tuition_state']) and $data['tuition_state'] == $v['id']): ?>checked="checked"<?php else: if(!isset($data['tuition_state']) and isset($v['checked']) and $v['checked'] == true): ?>checked="checked"<?php endif; endif; ?> data-am-ucheck /> <?php echo ($v["name"]); ?>
						</label><?php endforeach; endif; ?>
				</div> -->
			</div>
			<div class="am-form-group">
				
				<button type="submit" class="am-btn am-btn-primary am-radius btn-loading-example am-btn-sm w100" data-am-loading="{loadingText:'<?php echo L('common_form_loading_tips');?>'}"><?php echo L('common_operation_save');?></button>
			</div>
		</form>
        <!-- form end -->
	</div>
</div>
<!-- right content end  -->
		
<!-- footer start -->
<!-- commom html start -->
<!-- delete html start -->
<div class="am-modal am-modal-confirm" tabindex="-1" id="common-confirm-delete">
	<div class="am-modal-dialog am-radius">
		<div class="am-modal-bd"><?php echo L('common_delete_tips');?></div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel><?php echo L('common_operation_cancel');?></span>
			<span class="am-modal-btn" data-am-modal-confirm><?php echo L('common_operation_confirm');?></span>
		</div>
	</div>
</div>
<!-- delete html end -->

<!-- delete html start -->
<div class="am-modal am-modal-confirm" tabindex="-1" id="common-confirm-qiandao">
	<div class="am-modal-dialog am-radius">
		<div class="am-modal-bd">确定为该学生签到吗？</div>
		<div class="am-modal-footer">
			<span class="am-modal-btn" data-am-modal-cancel><?php echo L('common_operation_cancel');?></span>
			<span class="am-modal-btn" data-am-modal-confirm><?php echo L('common_operation_confirm');?></span>
		</div>
	</div>
</div>
<!-- delete html end -->

<div class="am-modal am-modal-no-btn" tabindex="-1" id="doc-modal-1">
		<div class="am-modal-dialog">
		  <div class="am-modal-hd">生日提醒
			<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
		  </div>
		  <div class="am-modal-bd">
			<table class="am-table am-table-striped am-table-compact am-table-hover xs_shengri" >
					<thead>
							<tr>
								<th colspan="3">一周内学生生日提醒</th>
								
							</tr>
							<!-- <tr>
									<th >姓名</th>
									<th >日期</th>
									<th >星期</th>
									
								</tr> -->
					</thead>
					<tbody>
							<?php if(!empty($xs_shengri)): if(is_array($xs_shengri)): foreach($xs_shengri as $key=>$v): ?><tr>
													<!-- <td ><a href="javascript:;" data-type="nav" data-url="<?php echo U('Admin/Xuesheng/saveinfo',array('id'=>$v['id']));?>"><?php echo ($v["username"]); ?></a></td> -->
													<td ><a href="javascript:;" ><?php echo ($v["username"]); ?></a></td>
													<td><?php echo ($v["riqi"]); ?></td>
													<td>星期<?php echo ($v["xingqi"]); ?></td>
												</tr><?php endforeach; endif; ?>
									<?php else: ?>
									
									<tr><td>无</td></tr><?php endif; ?>
						</tbody>
			</table>
		  </div>
		</div>
	  </div>
<!-- commom html end -->
</body>
</html>

<!-- 类库 -->
<script type="text/javascript" src="/Public/Common/Lib/jquery/jquery-2.1.0.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/assets/js/amazeui.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/echarts/echarts.min.js"></script>

<!-- ueditor 编辑器 -->
<script type="text/javascript" src="/Public/Common/Lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/ueditor/lang/zh-cn/zh-cn.js"></script>

<!-- 颜色选择器 -->
<script type="text/javascript" src="/Public/Common/Lib/colorpicker/jquery.colorpicker.js"></script>

<!-- 元素拖拽排序插件 -->
<script type="text/javascript" src="/Public/Common/Lib/dragsort/jquery.dragsort-0.5.2.min.js"></script>

<!-- amazeui插件 -->
<script type="text/javascript" src="/Public/Common/Lib/amazeui-switch/amazeui.switch.min.js"></script>
<script type="text/javascript" src="/Public/Common/Lib/amazeui-chosen/amazeui.chosen.min.js"></script>

<!-- 项目公共 -->
<script type="text/javascript" src="/Public/Common/Js/Common.js"></script>
<script type="text/javascript" src="/Public/Admin/<?php echo ($default_theme); ?>/Js/layer/layer.js"></script>

<!-- 控制器 -->
<?php if(!empty($module_js)): ?><script type="text/javascript" src="/Public/<?php echo ($module_js); ?>"></script><?php endif; ?>

<script>
	setInterval(function() {
    var now = (new Date()).toLocaleString();
    $('#current-time').text(now);
}, 1000);
    $('#doc-modal-1').on('close.modal.amui', function(){
        var url = "<?php echo U('Admin/Admin/update_tixiang');?>";
        console.log(url);
       $.get(url);
        
      });
    
//   $("#yizhiwei_01").trigger('click');    
</script>
<?php if($is_tx): ?><script>
      $("#yizhiwei_01").trigger('click');  
</script><?php endif; ?>
<!-- footer end -->