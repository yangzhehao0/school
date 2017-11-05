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
		<form class="am-form form-validation view-save" action="<?php echo U('Admin/Caiwu/Save');?>" method="POST" request-type="ajax-url" request-value="<?php echo U('Admin/Kehu/Index');?>">
			<legend>
				<span class="fs-16">
					<?php if(empty($data['id'])): echo L('fraction_add_name');?>
					<?php else: ?>
						<?php echo L('fraction_edit_name'); endif; ?>
				</span>
				<a href="<?php echo U('Admin/Kehu/Index');?>" class="fr fs-14 m-t-5 am-icon-mail-reply"> <?php echo L('common_operation_back');?></a>
			</legend>
			<div class="am-form-group">
				<label><?php echo L('fraction_username_text');?></label>
				<input type="text" placeholder="<?php echo L('fraction_username_text');?>" minlength="2" maxlength="16" data-validation-message="<?php echo L('fraction_student_username_format');?>" class="am-radius" <?php if(isset($student)): ?>value="<?php echo ($student["username"]); ?>"<?php endif; ?> disabled required />
			</div>
			
			<div class="am-form-group">
				<label><?php echo L('fraction_subject_text');?></label>
				<select name="kecheng" class="am-radius c-p" data-validation-message="<?php echo L('fraction_subject_format');?>" required>
					<option value=""><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($subject_list)): foreach($subject_list as $key=>$v): ?><option value="<?php echo ($v["name"]); ?>" <?php if(isset($data['kecheng']) and $data['kecheng'] == $v['name']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>课程时长</label>
				<input type="number" name="kc_sc" placeholder="课程时长" pattern="<?php echo L('common_regex_score');?>" data-validation-message="课程时长" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["kc_sc"]); ?>"<?php endif; ?> required />
			</div>
			<div class="am-form-group">
				<label>价格</label>
				<input type="number" name="kc_jq"  placeholder="价格" pattern="<?php echo L('common_regex_jiage');?>" data-validation-message="价格" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["kc_jq"]); ?>"<?php endif; ?> required />
			</div>
			<div class="am-form-group">
				<label>已付款金额</label>
				<input type="number" name="yj_price"  placeholder="已付款金额" pattern="<?php echo L('common_regex_jiage');?>" data-validation-message="已付款金额" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["yj_price"]); ?>"<?php endif; ?> required />
			</div>
			<div class="am-form-group">
					<label>剩余付款金额</label>
					<input type="number" name="sy_price"  placeholder="剩余付款金额" pattern="<?php echo L('common_regex_jiage');?>" data-validation-message="剩余付款金额" class="am-radius" <?php if(isset($data)): ?>value="<?php echo ($data["sy_price"]); ?>"<?php endif; ?> required />
				</div>
			<div class="am-form-group">
				<label>合同开始日期</label>
				<input type="text" name="ht_start" class="am-radius" placeholder="合同开始日期" pattern="<?php echo L('common_regex_birthday');?>" data-validation-message="合同开始日期" <?php if(!empty($data)): ?>value="<?php echo ($data["ht_start"]); ?>"<?php endif; ?> data-am-datepicker="{format: 'yyyy-mm-dd', viewMode: 'years'}" readonly required />
			</div>
			<div class="am-form-group">
				<label>合同结束日期</label>
				<input type="text" name="ht_end" class="am-radius" placeholder="合同结束日期" pattern="<?php echo L('common_regex_birthday');?>" data-validation-message="合同结束日期" <?php if(!empty($data)): ?>value="<?php echo ($data["ht_start"]); ?>"<?php endif; ?> data-am-datepicker="{format: 'yyyy-mm-dd', viewMode: 'years'}" readonly required />
			</div>
			<div class="am-form-group">
				<label>财务</label>
				<select name="cw_id" class="am-radius c-p" data-validation-message="财务" required>
					<option value=""><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($caiwu_list)): foreach($caiwu_list as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>" <?php if(isset($data['cw_id']) and $data['cw_id'] == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["realname"]); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>合同状态</label>
				<select name="ht_status" class="am-radius c-p" data-validation-message="合同状态" required>
					<option value=""><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($ht_status)): foreach($ht_status as $key=>$v): ?><option value="<?php echo ($key); ?>" <?php if(isset($data['ht_status']) and $data['ht_status'] == $key): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; ?>
				</select>
			</div>
			<div class="am-form-group">
				<label>付款状态</label>
				<select name="pay_status" class="am-radius c-p" data-validation-message="财务" required>
					<option value=""><?php echo L('common_select_can_choose');?></option>
					<?php if(is_array($pay_status)): foreach($pay_status as $key=>$v): ?><option value="<?php echo ($key); ?>" <?php if(isset($data['pay_status']) and $data['pay_status'] == $key): ?>selected<?php endif; ?>><?php echo ($v); ?></option><?php endforeach; endif; ?>
				</select>
			</div>

			<div class="am-form-group">
				<label>备注</label>
				<textarea rows="3" maxlength="255" name="beizhu" class="am-radius" placeholder="备注" data-validation-message="备注"><?php if(isset($data)): echo ($data["beizhu"]); endif; ?></textarea>
			</div>
			<div class="am-form-group">
				<input type="hidden" name="kh_name" <?php if(isset($student)): ?>value="<?php echo ($student["username"]); ?>"<?php endif; ?>">
				<input type="hidden" name="kh_id" <?php if(isset($student)): ?>value="<?php echo ($student["id"]); ?>"<?php endif; ?>" />
				<input type="hidden" name="id" <?php if(isset($data)): ?>value="<?php echo ($data["id"]); ?>"<?php endif; ?>" />
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