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
		<form class="am-form admin-list" action="<?php echo U('Admin/Admin/Index');?>" method="POST">
			<div class="am-g">
				<select  class="am-radius c-p" name="role_id">
					<option value=""><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($role)): foreach($role as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(isset($param['role_id']) and $param['role_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
				</select>
				<input type="text" class="am-radius" placeholder="<?php echo L('login_username_text');?>" name="username" <?php if(isset($param['username'])): ?>value="<?php echo ($param["username"]); ?>"<?php endif; ?> />
				<button type="submit" class="am-btn am-btn-secondary am-btn-sm am-radius"><?php echo L('common_operation_query');?></button>
			</div>
		</form>
		<!-- form end -->

		<!-- operation start -->
		<div class="am-g m-t-15">
			<a href="<?php echo U('Admin/Admin/SaveInfo');?>" class="am-btn am-btn-secondary am-radius am-btn-xs am-icon-plus"> <?php echo L('common_operation_add');?></a>
		</div>
		<!-- operation end -->

		<!-- list start -->
		<table class="am-table am-table-striped am-table-hover am-text-middle m-t-10">
			<thead>
				<tr>
					<th><?php echo L('common_admin_name');?></th>
					<th>角色</th>
					<th>名称</th>
					<th><?php echo L('common_view_gender_name');?></th>
					<th><?php echo L('login_total_name');?></th>
					<th class="am-hide-sm-only"><?php echo L('login_last_time_name');?></th>
					<th class="am-hide-sm-only"><?php echo L('common_create_time_name');?></th>
					<th><?php echo L('common_operation_name');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(!empty($list)): if(is_array($list)): foreach($list as $key=>$v): ?><tr id="data-list-<?php echo ($v["id"]); ?>">
							<td><?php echo ($v["username"]); ?></td>
							<td><?php echo get_role_name($v['role_id']);?></td>
							<td><?php echo ($v["realname"]); ?></td>
							<td><?php echo L('common_gender_list')[$v['gender']]['name'];?></td>
							<td><?php echo ($v["login_total"]); ?></td>
							<td class="am-hide-sm-only">
								<?php if($v['login_total'] == 0): echo L('common_not_login_name');?>
								<?php else: ?>
									<?php echo date('Y-m-d H:i:s', $v['login_time']); endif; ?>
							</td>
							<td class="am-hide-sm-only"><?php echo date('Y-m-d H:i:s', $v['add_time']);?></td>
							<td>
								<?php if($v['id'] == 1): ?><span class="cr-ccc"><?php echo L('common_do_not_operate');?></span>
								<?php else: ?>
									<a href="<?php echo U('Admin/Admin/SaveInfo', array('id'=>$v['id']));?>">
										<button class="am-btn am-btn-default am-btn-xs am-radius am-icon-edit" data-am-popover="{content: '<?php echo L('common_operation_edit');?>', trigger: 'hover focus'}"></button>
									</a>
									<?php if($v['id'] != $admin['id']): ?><button class="am-btn am-btn-default am-btn-xs am-radius am-icon-trash-o submit-delete" data-url="<?php echo U('Admin/Admin/Delete');?>" data-am-popover="{content: '<?php echo L('common_operation_delete');?>', trigger: 'hover focus'}" data-id="<?php echo ($v["id"]); ?>"></button><?php endif; endif; ?>
							</td>
						</tr><?php endforeach; endif; ?>
				<?php else: ?>
					<tr><td colspan="5" class="table-no"><?php echo L('common_not_data_tips');?></td></tr><?php endif; ?>
			</tbody>
		</table>
		<!-- list end -->

		<!-- page start -->
		<?php if(!empty($list)): echo ($page_html); endif; ?>
		<!-- page end -->
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