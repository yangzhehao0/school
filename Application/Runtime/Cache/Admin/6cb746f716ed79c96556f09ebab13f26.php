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
		<form class="am-form form-validation view-save" action="<?php echo U('Admin/Admin/Save');?>" method="POST" request-type="ajax-url" request-value="<?php echo U('Admin/Admin/Index');?>">
			<legend>
				<span class="fs-16">
					<?php if(empty($user['id'])): echo L('admin_add_name');?>
					<?php else: ?>
						<?php echo L('admin_edit_name'); endif; ?>
				</span>
				<a href="<?php echo U('Admin/Admin/Index');?>" class="fr fs-14 m-t-5 am-icon-mail-reply"> <?php echo L('common_operation_back');?></a>
			</legend>
			<div class="am-form-group">
				<label><?php echo L('login_username_text');?></label>
				<input type="text" placeholder="<?php echo L('login_username_text');?>" name="username" pattern="<?php echo L('common_regex_username');?>" data-validation-message="<?php echo L('login_username_format');?>" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["username"]); ?>" disabled<?php endif; ?> required />
			</div>
			<div class="am-form-group">
				<label><?php echo L('login_login_pwd_text');?></label>
				<input type="password" placeholder="<?php echo L('login_login_pwd_text');?>" name="login_pwd" pattern="<?php echo L('common_regex_pwd');?>"  data-validation-message="<?php echo L('login_login_pwd_format');?>" class="am-radius" <?php if(!isset($data)): ?>required<?php endif; ?> />
			</div>
			<div class="am-form-group">
				<label>名称</label>
				<input type="text" placeholder="名称" name="realname"  data-validation-message="名称" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["realname"]); ?>"<?php endif; ?> required/>
			</div>
			<div class="am-form-group">
				<label><?php echo L('common_mobile_name');?></label>
				<input type="text" placeholder="<?php echo L('common_mobile_name');?>" name="mobile" pattern="<?php echo L('common_regex_mobile');?>" data-validation-message="<?php echo L('common_mobile_format_error');?>" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["mobile"]); ?>"<?php endif; ?> />
			</div>
			<?php if($admin['id'] != $data['id']): ?><div class="am-form-group">
					<label><?php echo L('admin_view_role_name');?></label>
					<select  class="am-radius c-p" name="role_id" data-validation-message="<?php echo L('login_role_id_format');?>" required>
						<option value=""><?php echo L('common_select_can_choose');?></option>
						<?php if(is_array($role)): foreach($role as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(isset($data['role_id']) and $data['role_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
					</select>
				</div><?php endif; ?>
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
				<input type="hidden" name="id" <?php if(isset($id)): ?>value="<?php echo ($id); ?>"<?php endif; ?>" />
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
								<th>一周内学生生日提醒</th>
								
							</tr>
					</thead>
					<tbody>
							<?php if(!empty($xs_shengri)): if(is_array($xs_shengri)): foreach($xs_shengri as $key=>$v): ?><tr>
													<!-- <td ><a href="javascript:;" data-type="nav" data-url="<?php echo U('Admin/Xuesheng/saveinfo',array('id'=>$v['id']));?>"><?php echo ($v["username"]); ?></a></td> -->
													<td ><a href="javascript:;" ><?php echo ($v["username"]); ?></a></td>
													<td><?php echo ($v["riqi"]); ?></td>
													<td>星期<?php echo ($v["xingqi"]); ?></td>
												</tr><?php endforeach; endif; endif; ?>


						
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